<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\Company;
use CodeIgniter\HTTP\ResponseInterface;

class CompanyController extends BaseController
{
    public function index()
    {
        $title = 'Company List';

        $companyModel = new Company();
        $companyData = $companyModel->findAll();
        return view('Admin\Views\Company\CompanyListView',compact('title','companyData'));
    }
}
