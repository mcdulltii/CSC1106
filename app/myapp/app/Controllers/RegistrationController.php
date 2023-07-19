<?php 

namespace App\Controllers;

use App\Models\UserModel;

class RegistrationController extends BaseController
{
    public function index()
    {
        helper('form');

        $model = model(UserModel::class);

        // Checks whether the form is submitted.
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('registration');
        }

        $post = $this->request->getPost(['user_name', 'password', 'confirmpassword']);

        // Checks whether the submitted data passed the validation rules.
        if (!$this->validateData($post, [
            'user_name' => 'required|min_length[8]|max_length[255]|is_unique[user.user_name]',
            'password' => 'required|min_length[8]|max_length[255]', 
            'confirmpassword' => 'required|matches[password]'
        ])) {
            // The validation fails, so returns the form.
            return view('registration');
        }

        $data = [
            'user_name' => $post['user_name'],
            'user_password_hash' => password_hash($post['password'], PASSWORD_DEFAULT)
        ];

        $model->save($data); 
        return redirect('/', 'refresh');
    }
}
