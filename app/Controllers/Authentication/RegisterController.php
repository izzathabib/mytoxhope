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

    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        # Check if registration is allowed
        /*if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }*/

        

        $users = $this->getUserProvider();
        $companyModel = new Company();


        $comp_reg_no = $this->request->getPost('comp_reg_no');

        # Check if registration is allowed
        # User cannot register if the company registration no already exist in database
        # Get the existing user with the same comp_reg_no data
        $existingUser = $companyModel->where('comp_reg_no', $comp_reg_no)->first();

        // Action if the comp_reg_no already exists
        if ($existingUser) {
            $error = "A user with the same Company Registration Number already exists. For assistance, please contact ".$existingUser['comp_admin'];
            return redirect()->back()->withInput()
            ->with('error', $error);
        }

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        

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

        // Part to save data to company table
        //$companyModel = new Company();
        $companyData = [
            'user_id' => auth()->user()->id,
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
            'comp_name' => $this->request->getPost('comp_name'),
            'comp_email' => $this->request->getPost('email'),
            'comp_admin' => $this->request->getPost('username'),
        ];

        // Save data to companies table
        $companyModel->save($companyData);

        // Success!
        return redirect()->to(config('Auth')->registerRedirect())
            ->with('message', lang('Auth.registerSuccess'));
    }
}