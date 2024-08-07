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
            return redirect()->back()->with('currentPass', 'Current password is incorrect');
        }

        // Rule new password format
        $rules = [
            'new_password' => [
                'label' => 'New password',
                'rules' => 'required|max_byte[72]|strong_password[]',
                'errors' => [
                    'max_byte' => 'Auth.errorPasswordTooLongBytes'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate the new password match with the comfirm new password field
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('matchPass', 'New passwords do not match');
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

    public function editCompany() {

        $title = 'Company Profile';

        $companyModel = new Company();
        $userModel = new UserModel();
        
        $companyData = $companyModel
        ->select('company.comp_name, company.comp_reg_no, company.comp_id, company.comp_admin')
        ->join('users', 'users.comp_id = company.comp_id')
        ->where('users.id', auth()->user()->id)
        ->get()
        ->getResult();

        // Get the company admin detail
        foreach ($companyData as $data) {
            $admin = $data->comp_admin;
        }
        
        $adminData = $userModel->where('id',$admin)->first();

        // Get current user data
        $currentUserData = $userModel->find(auth()->user()->id);

        // Get all user with the associate company to display as main administrator option
        if (auth()->user()->inGroup('superadmin')) {
            $userData = $userModel
            ->select('users.username, users.id')
            ->where('users.comp_id', $currentUserData->comp_id)
            ->get()
            ->getResult();
        } else {
            $userData = $userModel
            ->select('users.username, users.id')
            ->join('groups_users', 'users.id = groups_users.user_id')
            ->where('users.comp_id', $currentUserData->comp_id)
            ->where('groups_users.group', 'admin')
            ->get()
            ->getResult();
        }
        
        //dd($userData);
        return view('Admin\Views\Profile\compProfileView', compact('title','companyData', 'userData', 'adminData'));
    }

    public function saveEditCompProfile($compId) {

        $companyData = [
            'comp_name' => $this->request->getPost('comp_name'),
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
        ];

        $companyModel = new Company();
        $companyModel->update($compId,$companyData);

        return redirect()->back()->with('compInfo', 'Company information updated successfully');

    }

    public function saveMainAdminChanges($compId) {

        $companyData = [
            'comp_admin' => $this->request->getPost('comp_admin'),
        ];

        $companyModel = new Company();
        $companyModel->update($compId,$companyData);

        return redirect()->back()->with('adminChange', 'Main administrator changed successfully');

    }

}
