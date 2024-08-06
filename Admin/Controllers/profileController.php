<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\Company;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\HTTP\ResponseInterface;

class profileController extends BaseController
{
    public function index() {

        $title = 'Profile'; 
        $userModel = new UserModel();

        $userData = $userModel
        ->select('users.*, identities.secret')
        ->join('identities', 'users.id = identities.user_id')
        ->where('users.id', auth()->user()->id)
        ->get()
        ->getResult();

        return view('Admin\Views\Profile\profileView', compact('title','userData'));
    }

    public function saveEditProfile($id) {
        $userModel = new UserModel();
        $identityModel = new UserIdentityModel();

        $userData = [
           'username' => $this->request->getPost('username'), 
        ];

        $identityUpdate = [
            'secret' => $this->request->getPost('email'),
        ];
        // Get data of specific row
        $identityData = $identityModel->where('user_id',$id)->first();
        // Get the ID associate with the data fetch earlier
        $identityId = $identityData->id;
        
        $identityModel->update($identityId,$identityUpdate);
        $userModel->update($id,$userData);
        return redirect()->back()->with('personalInfo', 'Personal information updated successfully');
    }

    protected function getUserEntity(): User
    {
        return new User();
    }

    public function updatePassword()
    {
        $session = session();
        $userArray = $session->get('user'); // Assuming user data is stored in session as an array

        // Convert array to User entity
        $user = new User($userArray);

        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate the current password
        if (!password_verify($currentPassword, $user->password_hash)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Validate the new password and confirmation
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'New passwords do not match');
        }

        // Update the password
        $user->password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $userModel = new UserModel();
        $userModel->save($user);

        auth()->logout(); 

        // Success!
        $session = session();
        $session->setFlashdata('password', "Password updated successfully! Please log in with your new password.");
        return redirect()->to('/login');
    }

}
