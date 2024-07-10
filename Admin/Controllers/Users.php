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
        $title = 'Users List';
        $companyModel = new Company();
        $companyData = $companyModel->findAll();
        return view('Admin\Views\UsersView',compact('title','companyData'));
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
