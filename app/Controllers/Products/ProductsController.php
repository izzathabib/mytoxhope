<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Products\Product;

class ProductsController extends BaseController
{
    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function addProduct() {
        $title = 'Add product';
        
        return view('Products/addProductView',compact('title'));
    }

    public function productList() {
        $title = 'Product List';


        $currentUserId = auth()->user()->id;

        $productData = $this->db->query("SELECT * FROM products WHERE user_id = '$currentUserId'")->getResult();

        return view('Products/productListView', compact('title','productData'));
    }

    public function displayProdDetail($id) {

        $title = 'Product Detail';
        $productModel = new Product();

        $productData = $productModel->find($id);

        return view('Products/displayProductView',compact('title','productData'));

    }

    public function saveProdDetail() {
        // Declare instances for model
        $productModel = new Product();

        // Get image from user uploaded file
        $product_image = $this->request->getFile('product_image');
        $product_image->move('public/assets/images/product');

        // Get msds from user uploaded file
        $msds = $this->request->getFile('msds');
        $msds->move('public/assets/documents');


        // Fetch data for each of the field
        $productData = [
            "user_id" => auth()->user()->id,
            "product_name" => $this->request->getPost('product_name'),
            "product_image" => $product_image->getClientName(),
            "type_poison" => $this->request->getPost('type_poison'),
            "active_ing" => $this->request->getPost('active_ing'),
            "inactive_ing" => $this->request->getPost('inactive_ing'),
            "brand_name" => $this->request->getPost('brand_name'),
            "msds" => $msds->getClientName(),
            "subtype_household" => $this->request->getPost('subtype_household'),
        ];

        // Save $model data to database
        $productModel->save($productData);

        $id = $productModel->insertID();

        // Check if the data have been save
        if ($productModel) {
            return redirect()->to(base_url('display-prod-detail/'.$id));
        }
    }

    
}
