<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        helper('form');

        $model = model(UserModel::class);

        // Checks whether the form is submitted.
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('login');
        }

        $post = $this->request->getPost(['username', 'password']);

        // Checks whether the submitted data passed the validation rules.
        if (!$this->validateData($post, [
            'username' => 'required',
            'password' => 'required',
        ])) {
            // The validation fails, so returns the form.
            return view('login');
        }

        $data = [
            'user_name' => $post['username'],
            'user_password_hash' => password_hash($post['password'], PASSWORD_DEFAULT)
        ];

        if ($data['user_password_hash'] === $model->getUserPasswordHash($data['user_name']))
        {
            $session = \Config\Services::session();
            // Set the user ID
            $session->set('user_id', $model->getUserID($data['user_name']));

            return redirect('/', 'refresh');
        } else {
            // The validation fails, so returns the form.
            return view('login');
        }
    }

    public function logout() {
        $session = \Config\Services::session();
        $session->remove('user_id');

        return redirect('login', 'refresh');
    }
}
