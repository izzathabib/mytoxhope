<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\Company;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Events\Events;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Validation\ValidationRules;
use CodeIgniter\Shield\Entities\User;

class Users extends BaseController
{

    public function __construct() {
        $this->db = \Config\Database::connect();

    }

    public function index()
    {
        $title = 'User List';
        $userModel = new UserModel();

        // Display all user if current user is superadmin
        if (auth()->user()->inGroup('superadmin')) {
            $userData = $userModel
            ->select('users.*, company.*, identities.secret') 
            ->join('company', 'users.comp_id = company.comp_id')
            ->join('identities', 'users.id = identities.user_id') 
            ->get()
            ->getResult();
            return view('Admin\Views\UsersView',compact('title','userData'));
        }

        // Get current user id
        $currentUserId = $userModel->find(auth()->user()->id);
        // Get current user company ID
        $currentUserCompId = $currentUserId->comp_id;

        $userData = $userModel
            ->select('users.*, company.*, identities.secret') 
            ->join('company', 'users.comp_id = company.comp_id')
            ->join('identities', 'users.id = identities.user_id')
            ->where('users.comp_id', $currentUserCompId) 
            ->get()
            ->getResult();

        return view('Admin\Views\UsersView',compact('title','userData'));
    }

    public function verifyUser($id) {

        $userData = $this->db->query(
            "SELECT users.*, company.*
            FROM users
            INNER JOIN company ON users.comp_id=company.comp_id
            WHERE users.id = $id;"
        )->getResult();

        if (empty($userData)) {
            // Handle case where no user found with the ID
            return redirect()->to(base_url('Admin/users')); // Or display error message
        }

        $compId = isset($userData[0]->comp_id) ? $userData[0]->comp_id : null;

        if ($compId) {
            $companyData = [
                'status' => 'verified', // Replace with actual field and value
            ];
            $this->db->table('company')
                ->where('comp_id', $compId)
                ->update($companyData);
        }
        
        return redirect()->to(base_url('Admin/users'));
    }

    public function addNewUser() {
        $title = 'Add User';
        $companyModel = new Company();
        $userModel = new UserModel();

        // Superadmin will fetch all company
        if (auth()->user()->inGroup('superadmin')) {
            $companyData = $companyModel->findAll();
        } else {
            $currentUserId = $userModel->find(auth()->user()->id);
            $currentUserComp = $currentUserId->comp_id;
            $companyData = $companyModel->find($currentUserComp);
        }

        return view('Admin\Views\AddNewUserView', compact('title', 'companyData'));
    }

    public function saveUser() {

        // Declare object for Model
        $users = $this->getUserProvider();
        $companyModel = new Company();

        // Validation rule
        $rules = $this->getValidationRules();

        // If validation fail return back to the addUser page 
        /*if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }*/

        // Get user company registration number from user input
        $compRegNum = $this->request->getPost('comp_reg_no');
        // Get company ID
        $compId = $companyModel->where('comp_reg_no', $compRegNum)->first();

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));
        $user->comp_id = $compId['comp_id'];
        // Fetch user role from user input
        $role = [$this->request->getPost('role')];

        # Save data to users table
        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput();
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to user group
        $user->syncGroups(...$role);

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

        //$authenticator->completeLogin($user);

        // Send email to the user
        $email = \Config\Services::email();
        $email->setTo('muhdizat.h@gmail.com'); // Replace with your actual email address
        $email->setSubject('Test Email from CodeIgniter 4');
        $email->setMessage('This is a test email sent using MailEnable.');

        if ($email->send()) {

            // Success!
            $session = session();
            //$session->setFlashdata('success', "Registration successful!  We'll email you once your account is verified for login.");
            return redirect()->to('Admin/users');
        } else {
            return redirect()->back()
            ->with('error', 'Failed to send registration email to admin');
        }

    }

    /**
     * Returns the User provider
     */
    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();

        return $rules->getRegistrationRules();
    }

    /**
     * Returns the Entity class that should be used
     */
    protected function getUserEntity(): User
    {
        return new User();
    }
}
