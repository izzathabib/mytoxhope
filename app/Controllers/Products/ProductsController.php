<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductsController extends BaseController
{
    public function addProduct()
    {
        $title = 'Add product';
        return view('Products/addProductView',compact('title'));
    }
}
