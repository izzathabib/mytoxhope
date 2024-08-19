<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\Company;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use App\Models\UserModel;

class CompanyController extends BaseController
{
    public function index()
    {
        $title = 'Company List';

        $companyModel = new Company();
        $userModel = new UserModel();

        // Get current user id
        $currentUserData = $userModel
        ->join('company', 'company.comp_id = users.comp_id')
        ->find(auth()->user()->id);
        //dd($currentUserData);
        // Get all company detail 
        $companyData = $companyModel
        ->select('company.*, users.*, identities.secret') 
        ->join('users', 'company.comp_admin = users.id')
        ->join('identities', 'company.comp_admin = identities.user_id')
        ->orderBy('company.comp_id = ' . $currentUserData->comp_id . ' DESC, company.status ASC', '', false)
        ->orderBy('company.comp_name', 'ASC')
        ->get()
        ->getResult();
        
        return view('Admin\Views\Company\CompanyListView',compact('title','companyData'));
    }

    public function saveEditCompany($id)
    {
        //$title = 'Company List';

        $companyModel = new Company();
        $companyData = [
            'comp_name' => $this->request->getPost('comp_name'),
            'comp_reg_no' => $this->request->getPost('comp_reg_no')
        ];

        $companyModel->update($id,$companyData);
        session()->setFlashdata('success', 'Details Updated Successfully!');
        return redirect()->to('Admin/company');
    }

    public function deleteCompany($compId) {
        $companyModel = new Company();
        $companyModel->delete($compId);
        //dd($id);
        session()->setFlashdata('success', 'Company Deleted Successfully!');
        return redirect()->to('Admin/company');
    }

    public function addCompany() {

        $title = 'Add Company';

        // Generate random password to store as value for 'password' and 'pasword_again' input
        helper('text');
        $randomPassword = random_string('alnum', 8);
        
        return view('Admin\Views\Company\AddNewCompanyView', compact('title', 'randomPassword'));

    }

    public function saveNewCompany() {

        // Declare model being used
        $users = new UserModel;
        $companyModel = new Company();

        // Get the random password generated
        $generatedPass = $this->request->getPost('password');

        $comp_reg_no = $this->request->getPost('comp_reg_no');

        # Check if registration is allowed
        # User cannot register if their company already registered by PIC
        # Get the existing user with the same comp_reg_no data
        
        // Retrieve username and secret from table users and identities based on the company table
        $existingUser = $companyModel
        ->select('company.*, users.*, identities.secret') 
        ->join('users', 'company.comp_admin = users.id')
        ->join('identities', 'company.comp_admin = identities.user_id')
        ->where('company.comp_reg_no', $comp_reg_no) 
        ->get()
        ->getResult(); 

        // Action if the comp_reg_no already exists
        if ($existingUser) {
            foreach ($existingUser as $data) {
                $error = "A user with the same Company Registration Number already exists. For assistance, please contact ".$data->username."  (".$data->secret.")";
                return redirect()->back()->withInput()
                ->with('error', $error);
            }
        }

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = [
            'comp_reg_no' => [
                'label' => 'Company Registration No',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                ],
            ],
            'comp_name' => [
                'label' => 'Company Name',
                'rules' => [
                    'required',
                    'min_length[3]',
                ],
            ],
            'username' => [
                'label' => 'Auth.username',
                'rules' => [
                    'required',
                    'max_length[30]',
                    'min_length[3]',
                    'is_unique[users.username]',
                ],
            ],
            'email' => [
                'label' => 'Auth.email',
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                    'is_unique[identities.secret]',
                ],
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required|max_byte[72]|strong_password[]',
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes'
                ]
            ],
            'password_confirm' => [
                'label' => 'Auth.passwordConfirm',
                'rules' => 'required|matches[password]',
            ],
        ];
        
        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $companyData = [
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
            'comp_name' => $this->request->getPost('comp_name'),
            'status' => 'verified',
        ];

        try {
            $companyModel->save($companyData);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $companyModel->errors());
        }
        // Get registered company id
        $compId = $companyModel->getInsertID();

        // Save the user in UserModel
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $user->comp_id = $compId;

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        # Save data to users table
        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());
        
        // The registered user will be the company admin
        $compAdmin = $user->id;

        // Update comp_admin column on company table
        $companyData = [
            'comp_admin' => $compAdmin,
        ];
        $companyModel->update($compId,$companyData);
        //dd($companyData);

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);
        
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        //$authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }
        
        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Get the new registered company admin email
        $companyEmail = $user->email;
        
        // Send email to New Company (main admin) so they knew their company have been registered
        $email = \Config\Services::email();
        $email->setTo('muhdizat.h@gmail.com'); // Replace with your actual email address
        $email->setSubject('Mytoxhope Company Registration');

        $message = "
            <p>Pusat Racun Negara have registered your company in Mytoxhope system.</p>
            <p>You can login using the details below:</p>
            <p style='margin-left: 80px;'>
                <strong>Email:</strong> {$companyEmail}<br>
                <strong>Password:</strong> {$generatedPass}
            </p>
            <p><strong>Important:</strong> For your security, please change your password immediately after logging in.</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html');

        if ($email->send()) {
            // **Prevent automatic login:**
            //auth()->logout(); 

            // Success!
            /*$session = session();
            $session->setFlashdata('success', "Registration successful!  We'll email you once your account is verified for login.");*/
            session()->setFlashdata('success', 'Company Added Successfully!');
            return redirect()->to('Admin/company');
        } else {
            return redirect()->back()
            ->with('error', 'Failed to send registration email to admin');
        }

    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }
}
