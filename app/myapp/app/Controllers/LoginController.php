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
            'username' => 'required|min_length[8]|max_length[255]',
            'password' => 'required|min_length[8]|max_length[255]',
        ])) {
            // The validation fails, so returns the form.
            return view('login');
        }

        try {
            if (password_verify($post['password'], $model->getUserPasswordHash($post['username'])))
            {
                $session = \Config\Services::session();
                // Set the user ID
                $session->set('user_id', $model->getUserID($post['username']));

                return redirect('/', 'refresh');
            } else {
                // The validation fails, so returns the form.
                return view('login');
            }
        } catch (\Exception $e) {
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
