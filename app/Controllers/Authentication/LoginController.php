<?php

namespace App\Controllers\Authentication;

use App\Models\Company;
use App\Models\UserModel;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Models\UserIdentityModel;

class LoginController extends ShieldLogin
{

  public function __construct() {
        $this->db = \Config\Database::connect();
  }

  public function loginView()
  {
      if (auth()->loggedIn()) {
          return redirect()->to(config('Auth')->loginRedirect());
      }

      /** @var Session $authenticator */
      $authenticator = auth('session')->getAuthenticator();

      // If an action has been defined, start it up.
      if ($authenticator->hasAction()) {
          return redirect()->route('auth-action-show');
      }
      $title = 'Login';

      return $this->view(setting('Auth.views')['login'],compact('title'));
  }

  public function loginAction(): RedirectResponse
    {
        $identityModel = model(UserIdentityModel::class);
        $userModel = new UserModel();
        
        
        $email = $this->request->getPost('email');
        
        $existingUser = $identityModel->where('secret', $email)->first();
        if ($existingUser == null) {
            return redirect()->back()
            ->with('errors',"You dont have an account registered");
        }
        $existingUserId = $existingUser->user_id;
        
        //Fetch user data
        $userData = $userModel
        ->select('company.status')
        ->join('company', 'users.comp_id = company.comp_id')
        ->where('users.id', $existingUserId)
        ->get()
        ->getResult();
        
        foreach ($userData as $data) {
            if ($data->status=='unverified') {
                return redirect()->back()
                ->with('errors',"Account Verification Pending. For assistance, please contact Pusat Racun Negara.");
            }
        }

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var array $credentials */
        $credentials             = $this->request->getPost(setting('Auth.validFields')) ?? [];
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        return redirect()->to(config('Auth')->loginRedirect())->withCookies();
    }

    public function forgotPass() {

        $title = 'Forgot Password';

        return view('Shield/forgotPassView', compact('title'));

    }

    public function sentPasscode() {

        $title = 'Reset Password';
        $userIdentityModel = new UserIdentityModel();

        // Email validation
        $currentUserEmail = $this->request->getPost('email');

        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => [
                    'required',
                    'max_length[254]',
                    'valid_email',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Check if user with the email exist
        $currentUser = $userIdentityModel->where('secret', $currentUserEmail)->first();

        if ($currentUser == null) {
            return redirect()->back()->with('error', 'Email address doesn\'t exist. Please try again or create a new account.');
        }

        // Generated Passcode
        helper('text');
        $randomPasscode = random_string('alnum', 8);

        // Sent email to the user with the random password
        $email = \Config\Services::email();
        $email->setTo('muhdizat.h@gmail.com'); // For development purpose
        //$email->setTo($currentUserEmail);
        $email->setSubject('Login With Temporary Passcode');

        $message = "
            
            <p>You can login using the temporary passcode below:</p>
            <p style='margin-left: 80px;'>
                <strong>Password:</strong> {$randomPasscode}
            </p>
            <p><strong>Important:</strong> For your security, please change your password immediately after logging in.</p>
        ";

        $email->setMessage($message);
        $email->setMailType('html');

        $userData = [
            'secret2' => password_hash($randomPasscode, PASSWORD_DEFAULT),
        ];
        
        if ($email->send()) {

            $identityId = $currentUser->id;
            $userIdentityModel->update($identityId, $userData);
            return redirect()->to('login')->with('success', "We have email you the passcode. Please logging using the temporary passcode.");

        } else {

            return redirect()->back()
            ->with('error', 'Failed to send passcode to your email. Please try again.');

        }

    }
    
}