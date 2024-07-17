<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\Company;

class Users extends BaseController
{

    public function __construct() {
        $this->db = \Config\Database::connect();

    }

    public function index()
    {
        $title = 'User List';
        $userModel = new UserModel();

        // Get current user role
        if (auth()->user()->inGroup('superadmin')) {
            $userData = $this->db->query("SELECT * FROM users")->getResult();
            return view('Admin\Views\UsersView',compact('title','userData'));
        }

        // Get current user data from userModel
        $adminData = $userModel->find(auth()->user()->id);

        // Get user  comp_reg_no
        $adminCompRegNo = $adminData->comp_reg_no;

        // Get all user from UserModel with the same comp_reg_no
        $userData = $this->db->query("SELECT * FROM users WHERE comp_reg_no = '$adminCompRegNo' ")->getResult();

        return view('Admin\Views\UsersView',compact('title','userData'));
    }

    public function verifyUser($id) {

        $userModel = new UserModel();
        $userData = $userModel->find($id);

        $userData->status = 'verified';

        // Update data in users table
        $userModel->update($id, $userData);

        // Update data in company table as well
        $companyModel = new Company();
        $companyData = $companyModel->where('user_id', $id)->first();
        $companyData['status'] = 'verified';
        $companyModel->update($companyData['id'], $companyData);

        if ($userModel) {
            return redirect()->to(base_url('Admin/users'));
        }
    }

    public function addNewUser() {
        $title = 'Add User';

        return view('Admin\Views\AddNewUserView', compact('title'));
    }
}
