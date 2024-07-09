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
}
