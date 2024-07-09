<?php

namespace App\Controllers\Authentication;

use App\Models\Company;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;


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
        $companyModel = new Company();
        
        # Check if account have been verified by admin
        $email = $this->request->getPost('email');
        # Get the current user status
        $existingUser = $companyModel->where('comp_email', $email)->first();


        if ($existingUser['status']=='unverified') {
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