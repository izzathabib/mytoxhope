<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\Company;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class CompanyController extends BaseController
{
    public function index()
    {
        $title = 'Company List';

        $companyModel = new Company();
        $userModel = new UserModel();

        // Get current user id
        $currentUserId = $userModel->find(auth()->user()->id);
        
        // Get all company detail 
        $companyData = $companyModel
        ->select('company.*, users.*, identities.secret') 
        ->join('users', 'company.comp_admin = users.id')
        ->join('identities', 'company.comp_admin = identities.user_id')
        ->where('users.comp_id !=', $currentUserId->comp_id)
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

    public function deleteCompany($compId) {
        $companyModel = new Company();
        $companyModel->delete($compId);
        //dd($id);
        return redirect()->to('Admin/company');
    }
}
