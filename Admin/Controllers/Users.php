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
        // Declare instances for model
        $companyModel = new Company();

        $companyData = $companyModel->find($id);

        if ($companyData['status'] === 'unverified') {
            $companyData['status'] = 'verified'; // Change "verified" to your actual status value
            $companyModel->save($companyData);
        
            // Set flash message (optional)
            //$this->session->setFlashdata('success', 'Company verified successfully!');
        } 
        
        // Redirect to companies list or relevant page
        return redirect()->to(base_url('Admin/users'));
    }
}
