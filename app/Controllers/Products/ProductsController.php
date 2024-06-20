<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Products\Product;

class ProductsController extends BaseController
{
    public function addProduct()
    {
        $title = 'Add product';
        
        return view('Products/addProductView',compact('title'));
    }

    public function saveProdDetail()
    {
        $title = 'Product Detail';
        // Declare instances for model
        $model = new Product();

        // Fetch data for each of the field
        $product = [
            "user_id" => auth()->user()->id,
            "product_name" => $this->request->getPost('product_name'),
            "product_image" => $this->request->getPost('product_image'),
            "type_poison" => $this->request->getPost('type_poison'),
            "active_ing" => $this->request->getPost('active_ing'),
            "inactive_ing" => $this->request->getPost('inactive_ing'),
            "brand_name" => $this->request->getPost('brand_name'),
            "msds" => $this->request->getPost('msds'),
            "subtype_household" => $this->request->getPost('subtype_household'),
            "updated_at" => $this->request->getPost('updated_at'),
        ];

        // Save $model data to database
        $model->save($product);
        // Check if the data have been save
        if ($model) {
            return view('Products/displayProductView',compact('title','product'));
        }
    }

    
}
