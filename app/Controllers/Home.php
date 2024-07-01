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
        $title = 'Home';
        return view('home',compact('title'));
    }

    public function dashboard(): string
    {
        
        $title = 'Dashboard';

        return view('dashboard', compact('title'));
    }

    public function about(): string
    {
        $title = 'About MyToxHope';
        return view('about', compact('title'));
    }
}
