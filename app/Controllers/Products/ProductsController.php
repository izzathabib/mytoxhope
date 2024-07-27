<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Products\Product;
use App\Models\UserModel;
use App\Models\Company;
use RuntimeException;

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

        # Validate file input first
        // Get image from user uploaded file
        $product_image = $this->request->getFile('product_image');
        // Validate file
        if (!$product_image->isValid()) {
            $error_code = $product_image->getError();
            if ($error_code === UPLOAD_ERR_NO_FILE) {
                return redirect()->back()->withInput()
                ->with('image', 'No file selected');
            }
            throw new RuntimeException($product_image->getErrorString().''.$error_code);
        }
        // Restrict file type to only receive image
        if ( !in_array($product_image->getMimeType(), ['image/png', 'image/jpeg'])) {
            return redirect()->back()->withInput()
                ->with('image', 'Invalid file format');
        }
        // Store image
        $product_image->move('public/assets/images/product');


        // Get msds from user uploaded file
        $msds = $this->request->getFile('msds');
        // Validate file
        if (!$msds->isValid()) {
            $error_code = $msds->getError();
            if ($error_code === UPLOAD_ERR_NO_FILE) {
                return redirect()->back()->withInput()
                ->with('msds', 'No file selected');
            }
            throw new RuntimeException($msds->getErrorString().''.$error_code);
        }
        // Restrict file type to only receive image
        if ( !in_array($msds->getMimeType(), ['image/png', 'image/jpeg', 'application/pdf'])) {
            return redirect()->back()->withInput()
                ->with('msds', 'Invalid file format');
        }
        // Store document
        $msds->move('public/assets/documents');

        # Validate another input
        /*$rules = [
            'comp_name' => 'required',
            'product_name' => 'required',
            'type_poison' => 'required',
            'active_ing' => 'required',
            'inactive_ing' => 'required',
            'brand_name' => 'required',
            'subtype_household' => 'required',
        ];
        
        if (! $this->validateData($this->request->getPost(array_keys($rules)), $rules)) {
            $errors = $this->validator->getErrors();
            return redirect()->back()->withInput()->with('errors', $errors);
        }*/

        // Declare company model
        $companyModel = new Company();

        if (auth()->user()->inGroup('superadmin')) {
            // Fetch company ID based on company name
            $compName = $this->request->getPost('comp_name');
            $compData = $companyModel->where('comp_name', $compName)->first();
            $compId = $compData['comp_id'];
        } else {
            $compId = $this->request->getPost('comp_id');
        }

        // Fetch data for each of the field
        $productData = [
            "comp_id" => $compId,
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

        // Declare instances for model
        $productModel = new Product();

        // Save $model data to database
        $productModel->save($productData);

        // Get new product insert ID
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
