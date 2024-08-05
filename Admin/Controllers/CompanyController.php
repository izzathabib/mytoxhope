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
        // Get all company detail 
        $companyData = $companyModel
        ->select('company.*, users.*, identities.secret') 
        ->join('users', 'company.comp_admin = users.id')
        ->join('identities', 'company.comp_admin = identities.user_id')
        ->get()
        ->getResult();
        return view('Admin\Views\Company\CompanyListView',compact('title','companyData'));
    }

    public function saveEditCompany($id)
    {
        //$title = 'Company List';

        $companyModel = new Company();
        $companyData = [
            'comp_name' => $this->request->getPost('comp_name'),
            'comp_reg_no' => $this->request->getPost('comp_reg_no')
        ];

        $companyModel->update($id,$companyData);

        return redirect()->to('Admin/company');
    }
}
