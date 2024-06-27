<?php

namespace App\Controllers\Authentication;
use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\Login;

class RegisterController extends BaseController
{
    protected $helpers = ['form'];
    //protected $title = 'Company Registration';

    /*public function index()
    {
        $title = 'Register';
        if (! $this->request->is('post')) {
            return view('Shield/register');
        }

        $rules = [
            'comp_reg_no' => 'required|min_length[3]|max_length[20]|is_unique[users.comp_reg_no]',
            'comp_name' => 'required|min_length[3]|max_length[255]',
            'name' => 'required|min_length[3]|max_length[255]',
            'email' => 'required|valid_email|is_unique[identities.secret]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        $errors = [

        ];

        $data = $this->request->getPost(array_keys($rules));

        if (! $this->validateData($data, $rules)) {
            return view('Shield/register',compact('title'));
        }

        // If you want to get the validated data.
        $validData = $this->validator->getValidated();

        return view('Shield/success',compact('title'));
    }*/

    public function index() {
        $title = 'Company Registration';
        return view('Shield/register',compact('title'));
    }

    public function checkRegister() {
        $session = session(); 

        $title = 'Company Registration';
        $model = new UserModel();

        $userData = [
            'comp_reg_no' => $this->request->getPost('comp_reg_no'),
            'comp_name' => $this->request->getPost('comp_name'),
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'password_confirm' => $this->request->getPost('password_confirm'),
        ];

        // Get the existing user data
        $data = $model->where('comp_reg_no', $userData['comp_reg_no'])->first();

        // Action if the comp_reg_no already exists
        if ($data) {
            $currentUser = $userData['name'];
            $errors = "A user with the same Company Registration Number already exists. For assistance, please contact ".$currentUser;
            return view('Shield/register',compact('title','errors'));
        } else {
            return redirect()->to('/login');
        }

    }
}