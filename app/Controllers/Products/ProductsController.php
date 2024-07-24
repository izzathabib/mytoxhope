<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Products\Product;
use App\Models\UserModel;
use App\Models\Company;

class ProductsController extends BaseController
{
    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function addProduct() {
        $title = 'Add product';
        $companyModel = new Company();

        if (auth()->user()->inGroup('superadmin')) {
            $companyData = $companyModel->where('status','verified')->findAll();
        } else {
            $companyData = $companyModel->where('comp_id',auth()->user()->comp_id)->first();
        }
        
        return view('Products/addProductView',compact('title', 'companyData'));
    }

    public function productList() {
        $title = 'Product List';
        $productModel = new Product();
        $userModel = new UserModel();

        // Superadmin will see product from all company
        if (auth()->user()->inGroup('superadmin')) {
            $productData = $productModel
            ->select('products.*, company.comp_name') 
            ->join('company', 'products.comp_id = company.comp_id')
            ->get()
            ->getResult();
            return view('Products/productListView',compact('title','productData'));
        }

        // Get current user id
        $currentUserId = $userModel->find(auth()->user()->id);
        // Get current user company ID
        $currentUserCompId = $currentUserId->comp_id;

        $productData = $productModel
            ->select('products.*, company.comp_name') 
            ->join('company', 'products.comp_id = company.comp_id')
            ->where('products.comp_id', $currentUserCompId) 
            ->get()
            ->getResult();

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
            "comp_id" => $this->request->getPost('comp_name'),
            "product_name" => $this->request->getPost('product_name'),
            "product_image" => $product_image->getClientName(),
            "type_poison" => $this->request->getPost('type_poison'),
            "active_ing" => $this->request->getPost('active_ing'),
            "inactive_ing" => $this->request->getPost('inactive_ing'),
            "brand_name" => $this->request->getPost('brand_name'),
            "msds" => $msds->getClientName(),
            "subtype_household" => $this->request->getPost('subtype_household'),
            "prod_status" => 'Active',
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
            $productData['active_ing_array'] = explode(',', $productData['active_ing']);
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

        // Fetch data for each of the field
        $productData = [
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

    public function displayProdDiscontinue($id) {

        $title = 'Product Discontinued';
        $productModel = new Product();

        $productData = $productModel->find($id);

        $productData['prod_status'] = 'Discontinued';
        $productModel->update($id, $productData); 

        return view('Products/ProdDiscontinueView',compact('title','productData'));

    }
    
}
