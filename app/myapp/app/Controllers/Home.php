<?php

namespace App\Controllers;
use App\Models\FormModel;

class Home extends BaseController
{
    public function index()
    {
        $model = model(FormModel::class);
        $form['form'] = $model->getForms();
        return view('main_menu', $form);
    }
}
