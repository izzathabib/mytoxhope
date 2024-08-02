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
        $userData = $userModel->find($existingUserId);

        if ($userData->status=='unverified') {
            return redirect()->back()
            ->with('errors',"Account Verification Pending. For assistance, please contact Pusat Racun Negara.");
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
}