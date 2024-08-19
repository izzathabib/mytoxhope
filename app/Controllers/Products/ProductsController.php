<?php

namespace App\Controllers\Products;

use App\Controllers\BaseController;
use App\Models\Products\DeleteProduct;
use App\Models\Products\DeleteRequest;
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
            $companyData = $companyModel
            ->where('status','verified')
            ->where('comp_id !=', auth()->user()->comp_id)
            ->findAll();
        } else {
            $companyData = auth()->user()->id;
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
            ->join('users', 'products.user_id = users.id')
            ->join('company', 'users.comp_id = company.comp_id') 
            ->orderBy('company.comp_name', 'ASC')
            ->orderBy('products.updated_at', 'DESC')
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
        ->join('users', 'products.user_id = users.id')
        ->join('company', 'users.comp_id = company.comp_id')
        ->where('company.comp_id', $currentUserCompId)
        ->orderBy('products.user_id = ' . $currentUserId->id . ' DESC, products.updated_at DESC', '', false)
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

        

        // Fetch data for each of the field
        $productData = [
            "user_id" => $this->request->getPost('comp_name'),
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
        $id = $productModel->getInsertID();
        
        // Check if the data have been save
        if ($productModel) {
            session()->setFlashdata('success', 'Product added successfully!');
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

            $oldImagePath = 'public/assets/images/product/' . $oldImage;

            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $imageName = $newProductImage->getClientName();
            $newProductImage->move('public/assets/images/product');
        } else {
            $imageName = $oldImage;
        }

        // Move msds if new msds exist
        if ($newMsds->isValid() && !$newMsds->hasMoved()) {

            $oldMsdsPath = 'public/assets/documents/' . $oldMsds;

            if (file_exists($oldMsdsPath)) {
                unlink($oldMsdsPath);
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
            session()->setFlashdata('success', 'Product updated successfully!');
            return redirect()->to(base_url('display-prod-detail/'.$id));
        }
    }

    public function productDiscontinue($id) {

        $title = 'Product Discontinued';
        $productModel = new Product();

        $product = $productModel->find($id);

        $product['prod_status'] = 'Discontinued';
        $productModel->update($id, $product);
        
        /* Need to fetch again using the same method as in displayDisconDeleteProd() function 
        to ensure all the data can be display on ProdDiscontinueView */
        $productData = $productModel
                ->select('products.*') 
                ->where('products.id',$id)
                ->get()
                ->getResult();

        session()->setFlashdata('success', 'Product discontinued!');
        return view('Products/ProdDiscontinueView',compact('title','productData'));

    }

    public function productDelete($id) {

        $title = 'To Be Deleted';

        // Model used
        $productModel = new Product();
        $delProdModel = new DeleteProduct();
        $delReqModel = new DeleteRequest();
        
        // Get the product detail from products table
        $productData = $productModel->find($id);

        // Get the delete reason from the POST data
        $deleteReason = $this->request->getPost('deleteReason');

        # If prodcut is currently active, deletion of the product need to be approved by Admin PRN
        if ($productData['prod_status']=='Active') {
            if (auth()->user()->inGroup('admin','user')) {

                $productData['prod_status'] = 'To Be Deleted';
                $productModel->update($id,$productData);
                // Fetch data that eed to be stored in delete_requests table
                $deleteProduct = [
                    'prod_id' => $id,
                    'reason_deletion' => $this->request->getPost('deleteReason'),
                ];
                $delReqModel->save($deleteProduct);

                //Fetch product data using products table
                $productData = $productModel
                ->select('products.*, delete_requests.reason_deletion') 
                ->join('delete_requests', 'products.id = delete_requests.prod_id')
                ->where('products.id',$id)
                ->get()
                ->getResult();

                return view('Products/ProdDiscontinueView',compact('title','productData'));

            } else { 

                // For superadmin, directly delete the product
                $productData['reason_deletion'] = $deleteReason;
                // Insert all product data to delete_products table
                $delProdModel->insert($productData);
                // Delete product from products table
                $productModel->delete($id);
                session()->setFlashdata('success', 'Product Deleted Successfully!');
                return redirect()->to(base_url('list-product'));
            }
            
        } else { // If product status is currently 'Discontinued' it will straight away delete
            
            $productData['reason_deletion'] = $deleteReason;
            // Insert all product data to delete_products table
            $delProdModel->insert($productData);
            // Delete product from products table
            $productModel->delete($id);
            session()->setFlashdata('success', 'Product Deleted Successfully!');
            return redirect()->to(base_url('list-product'));
        }

    }

    public function displayDisconDeleteProd($id) {
        $productModel = new Product();
        
        $title = 'Product Detail';
        $product = $productModel->find($id);
        $productStatus = $product['prod_status'];

        // Using different query to fetch data for prod_status ('Discontinued' and 'To Be Deleted')
        if ($productStatus=='Discontinued') {
            $productData = $productModel
            ->select('products.*') 
            ->where('products.id',$id)
            ->get()
            ->getResult();
        } else {
            $productData = $productModel
            ->select('products.*, delete_requests.reason_deletion') 
            ->join('delete_requests', 'products.id = delete_requests.prod_id')
            ->where('products.id',$id)
            ->get()
            ->getResult();
        }

        return view('Products/ProdDiscontinueView',compact('title','productData'));
    }

    public function approveDelete($id) {
        // Model used
        $productModel = new Product();
        $delProdModel = new DeleteProduct();
        $delReqModel = new DeleteRequest();
        
        // Get the product detail from associate table
        $productData = $productModel
        ->select('products.*, delete_requests.reason_deletion') 
        ->join('delete_requests', 'products.id = delete_requests.prod_id')
        ->where('products.id',$id)
        ->get()
        ->getResult();
        
        // Fetch delete product data to insert
        foreach ($productData as $data) {
            $product_image = $data->product_image;
            $product_image_path = 'public/assets/images/product/' . $product_image;
            if (file_exists($product_image_path)) {
                unlink($product_image_path);
            }

            $msds = $data->msds;
            $msds_path = 'public/assets/documents/' . $msds;
            if (file_exists($msds_path)) {
                unlink($msds_path);
            }

            $deleteProduct = [
                'user_id' => $data->user_id,
                'product_name' => $data->product_name,
                'type_poison' => $data->type_poison,
                'active_ing' => $data->active_ing,
                'inactive_ing' => $data->inactive_ing,
                'brand_name' => $data->brand_name,
                'subtype_household' => $data->subtype_household,
                'reason_deletion' => $data->reason_deletion,
            ];
        }
        
        $delProdModel->save($deleteProduct);

        // Delete product from products and delete_requests table
        $productModel->delete($id);
        session()->setFlashdata('success', 'Delete Request Approved');
        return redirect()->to(base_url('list-product'));
        
    }
    
    public function rejectDelete($id) {
        $productModel = new Product();
        $delReqModel = new DeleteRequest();

        $productData = $productModel->find($id);
        $productData['prod_status'] = 'Active';
        $productModel->update($id,$productData);
        

        $deleteRequestData = $delReqModel->where('prod_id', $productData['id'])->first();
        $delReqModel->delete($deleteRequestData['id']);
        session()->setFlashdata('failed', 'Delete Request Rejected');
        return redirect()->to(base_url('list-product'));

    }

    public function productDeleteList() {

        $title = 'Delete Product';
        $delProductModel = new DeleteProduct();

        if (auth()->user()->inGroup('superadmin')) {
            $productData = $delProductModel
            ->select('delete_products.*, company.comp_name')
            ->join('users', 'users.id = delete_products.user_id')
            ->join('company', 'company.comp_id = users.comp_id')
            ->orderBy('delete_products.created_at', 'DESC') 
            ->orderBy('company.comp_name', 'ASC') 
            ->get()
            ->getResult();
        } else {
            $productData = $delProductModel
            ->select('delete_products.*')
            ->join('users', 'delete_products.user_id = users.id')
            ->where('users.comp_id', auth()->user()->comp_id)
            ->orderBy('delete_products.created_at', 'DESC')
            ->get()
            ->getResult();
        }
        

        return view('Products/BinView', compact('title','productData'));
    }

    public function delProdPermanent($id) {
        $delProductModel = new DeleteProduct();
        
        $delProductModel->delete($id);
        session()->setFlashdata('success', 'Product deleted successfully!');
        return redirect()->to(base_url('delete-product-list'));
    }

    public function activateProd($id) {
        $productModel = new Product();
        $delReqModel = new DeleteRequest();
        
        $productData = $productModel->find($id);

        # For activation process from "To Be Deleted" status.
        # To delete the record in 'delete_requests' table
        if ($productData['prod_status'] == 'To Be Deleted') {
            # For activation process from "To Be Deleted" status.
            $product = $productModel
            ->join('delete_requests', 'delete_requests.prod_id = products.id')
            ->find($id);
            
            $delReqModel->delete($product['id']);
        }
        # --#-- #

        $productData = [
            'prod_status' => 'Active' 
        ];
        $productModel->update($id, $productData);

        session()->setFlashdata('success', 'Product Activated Successfully!');
        return redirect()->to('list-product');
    }

    public function deleteRequestList() {

        $title = 'Delete Request';
        $delReqModel = new DeleteRequest();

        $productData = $delReqModel
        ->select('products.*, company.comp_name')
        ->join('products', 'products.id = delete_requests.prod_id')
        ->join('users', 'products.user_id = users.id')
        ->join('company', 'company.comp_id = users.comp_id')
        ->get()
        ->getResult();
        
        return view('Products/delReqView', compact('title', 'productData'));

    }

}
