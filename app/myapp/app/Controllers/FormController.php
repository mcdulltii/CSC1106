<?php

namespace App\Controllers;

class FormController extends BaseController
{
    public function goto_create()
    {
        return view('templates/header')
        . view('create_form')
        . view('templates/footer');
    }

    public function goto_details()
    {
        return view('templates/header')
        . view('update_form')
        . view('templates/footer');
    }
}
