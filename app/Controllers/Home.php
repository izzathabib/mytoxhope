<?php

namespace App\Controllers;

use App\Models\Company;

class Home extends BaseController
{
    public function __construct() {
        $this->db = \Config\Database::connect();
    }
    public function index(): string
    {
        return view('home');
    }

    public function dashboard(): string
    {
        // Create instance for model
        $model = new Company();
        // Fetch data from model
        $company_detail = $model -> findAll();

        return view('dashboard', compact('company_detail'));
    }
}
