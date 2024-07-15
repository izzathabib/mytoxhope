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

        return view('Products/singleProductView',compact('title','productData'));

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

    public function productUpdate($id) {
        
        $title = 'Update product detail';
        $productModel = new Product();
        $productData = $productModel->find($id);
        if (is_string($productData['active_ing'])) {
            $productData['active_ing'] = explode(',', $productData['active_ing']);
        }

        return view('Products/productUpdateView',compact('title','productData'));

    }

    public function saveUpdateDetail($id) {
        // Declare instances for model
        $productModel = new Product();
        $productData = $productModel->find($id);
        $oldImage = $productData['product_image'];
        $oldMsds = $productData['msds'];


        // Get the new uploaded file (image and msds)
        $newProductImage = $this->request->getFile('product_image');
        $newMsds = $this->request->getFile('msds');

        // Move image if new image exist
        if ($newProductImage->isValid() && !$newProductImage->hasMoved()) {
            if (file_exists('images/product'.$oldImage)) {
                unlink('images/product'.$oldImage);
            }
            $imageName = $newProductImage->getClientName();
            $newProductImage->move('public/assets/images/product');
        } else {
            $imageName = $oldImage;
        }

        // Move msds if new msds exist
        if ($newMsds->isValid() && !$newMsds->hasMoved()) {
            if (file_exists('documents/'.$oldMsds)) {
                unlink('documents/'.$oldMsds);
            }
            $msdsName = $newMsds->getClientName();
            $newMsds->move('public/assets/documents');
        } else {
            $msdsName = $oldMsds;
        }

        // Check if there 

        // Fetch data for each of the field
        $productData = [
            "user_id" => auth()->user()->id,
            "product_name" => $this->request->getPost('product_name'),
            "product_image" => $imageName,
            "type_poison" => $this->request->getPost('type_poison'),
            "active_ing" => $this->request->getPost('active_ing'),
            "inactive_ing" => $this->request->getPost('inactive_ing'),
            "brand_name" => $this->request->getPost('brand_name'),
            "msds" => $msdsName,
            "subtype_household" => $this->request->getPost('subtype_household'),
            "updated_at" => date('Y-m-d H:i:s'),
        ];

        // Save $model data to database
        $productModel->update($id, $productData);


        // Check if the data have been save
        if ($productModel) {
            return redirect()->to(base_url('display-prod-detail/'.$id));
        }
    }
    
}
