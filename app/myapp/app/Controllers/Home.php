<?php

namespace App\Controllers;
use App\Models\FormModel;

class Home extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $uid = $session->get('user_id');

        if (!$uid) {
            return redirect('register', 'refresh');
        } else {
            $model = model(FormModel::class);
            $form['form'] = $model->getForms($uid);
            return view('main_menu', $form);
        }
    }
}
