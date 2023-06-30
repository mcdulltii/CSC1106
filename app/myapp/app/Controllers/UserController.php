<?php

namespace App\Controllers;

use App\Models\UserModel; 

class UserController extends BaseController
{
    // Login
    public function index(){
    
    }

    // Register
    public function register(){

    }

    // Set User Session
    private function setUserSession($user){
        $data = [
            'user_id' => $user['user_id'],
            'user_name' => $user['user_name'],
            'isLoggedIn' => true,
        ];

        session() -> set($data);
        return true;
    }

    // Update Existing User Details
    public function update(){

        $data = [];
		helper('form');
        $model = model(UserModel::class);

        // Check whether form is submitted
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header')
                . view('update_user')
                . view('templates/footer');
        }

        // Data Validation
        $rules = [
            'user_name' => 'required|min_length[6]|max_length[30]',
        ];

        // if user wants to change password
        if ($this->request->getPost('password') != ''){
            $rules['password'] = 'required|min_length[8]|max_length[255]';
            $rules['password_confirm'] = 'matches[password]';
        } 
        

		if (! $this->validate($rules)) {
            $data['validation'] = $this->validator;
        }else{
            // Update existing record based on user_id
            $newData = [
                'user_id' => session()->get('user_id'),
                'user_name' => $this->request->getPost('user_name'),
                ];
                if($this->request->getPost('password') != ''){
                    $newData['password'] = $this->request->getPost('password');
                }
            $model->save($newData);

            session()->setFlashdata('success', 'Successfully Updated');
            return redirect()->to('/update');
        }

		$data['user'] = $model->where('user_id', session()->get('user_id'))->first();

		return view('templates/header')
            . view('update_user')
            . view('templates/footer');
	}

    // Delete User Account 
    public function delete(){
        $model = model(Usermodel::class);

        $user_id = session()->get('user_id');
        $model->delete($user_id);

        session()->setFlashdata('success','User Deleted');

        session()->destroy();

        return redirect()->to('/');
    }

    // Logout
    public function logout(){
		session()->destroy();
		return redirect()->to('/');
	}
}