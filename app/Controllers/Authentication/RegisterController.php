<?php

namespace App\Controllers\Authentication;
use App\Models\Company;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Entities\User;

class RegisterController extends ShieldRegister
{
    
    public function registerView() {
        $title = 'Company Registration';

        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        return view('Shield/register',compact('title'));
    }

    

    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Declare model being used
        $users = $this->getUserProvider();
        $companyModel = new Company();

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
        $rules = $this->getValidationRules();
        
        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Save user in company table
        //$allowedPostFields = array_keys($rules);
        //$companyData       = $this->getUserEntity();
        //$companyData->fill($this->request->getPost($allowedPostFields));

        $companyData = [
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
            'comp_name' => $this->request->getPost('comp_name'),
            'status' => 'unverified',
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

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }
        
        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Send email to adminPRN so they new registration happen for them to verify the user
        $email = \Config\Services::email();
        $email->setTo('muhdizat.h@gmail.com'); // Replace with your actual email address
        $email->setSubject('Test Email from CodeIgniter 4');
        $email->setMessage('This is a test email sent using MailEnable.');

        if ($email->send()) {
            // **Prevent automatic login:**
            auth()->logout(); 

            // Success!
            $session = session();
            $session->setFlashdata('success', "Registration successful!  We'll email you once your account is verified for login.");
            return redirect()->to('/login');
        } else {
            return redirect()->back()
            ->with('error', 'Failed to send registration email to admin');
        }

    }
}