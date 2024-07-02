<?php

namespace App\Controllers\Authentication;
use App\Models\Company;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Events\Events;




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

    public function registerAction(): RedirectResponse {
        //$session = session(); 

        $title = 'Company Registration';
        $model = $this->getUserProvider();
        $companyModel = new Company();

        $userData = [
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
            'comp_name' => $this->request->getPost('comp_name'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'password_confirm' => $this->request->getPost('password_confirm'),
        ];

        $companyData = [
            'registration_no' => $this->request->getPost('comp_reg_no'),
            'company_name' => $this->request->getPost('comp_name'),
            'email' => $this->request->getPost('email'),
            'admin' => $this->request->getPost('name'),
        ];

        // Get the existing user with the same comp_reg_no data
        $existingUser = $model->where('comp_reg_no', $userData['comp_reg_no'])->first();

        // Action if the comp_reg_no already exists
        if ($existingUser) {
            $error = "A user with the same Company Registration Number already exists. For assistance, please contact ".$existingUser->name;
            return redirect()->back()->withInput()
            ->with('error', $error)
            ->with('title', $title);
        }  

        $rules = [
            'comp_reg_no' => 'required|min_length[3]|max_length[20]|is_unique[users.comp_reg_no]',
            'comp_name' => 'required|min_length[3]|max_length[255]',
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[identities.secret]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        // If data validation fail
        if (! $this->validateData($userData, $rules)) {
        return redirect()->back()->withInput()
        ->with('errors', $this->validator->getErrors())
        ->with('title',$title);
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $userData              = $this->getUserEntity();
        $userData->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($userData->username === null) {
            $userData->username = null;
        }

        try {
            $model->save($userData);
            $companyModel->save($companyData);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $userData = $model->findById($model->getInsertID());

        // Add to default group
        $model->addToDefaultGroup($userData);

        Events::trigger('register', $userData, $companyData);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($userData);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $userData);
        if ($hasAction) {
            return redirect()->route('auth-action-show');
        }

        // Set the user active
        $userData->activate();

        $authenticator->completeLogin($userData);

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));


    }
}