<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FormBuilder extends BaseController
{
    public function __construct()
    {
        $session = \Config\Services::session();
        $session->set('user_id', 1);
        print_r($_SESSION);
    }
    
    public function index()
    {
        $_SESSION['form_id'] = null;
        return view('templates/header')
        .view('FormBuilder/form_builder', ['form' => null])
        .view('templates/footer');
    }

    public function saveForm()
    {
        $jsonPayload = $this->request->getJSON();
        $id = $_SESSION['form_id'] ?? null;

        if ($id) {
            $formModel = model(FormModel::class);
            $formModel->updateForm($id, [
                'form_blob' => $jsonPayload->formData
            ]);

            return view('FormBuilder/success');
        }
        else{
            $formModel = model(FormModel::class);
            $formModel->save([
                'form_blob' => $jsonPayload->formData,
                'user_id' => $_SESSION['user_id'],
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function editForm($id)
    {
        $formModel = model(FormModel::class);
        $form = $formModel->getForm($id);

        $_SESSION['form_id'] = $id;

        $data = [
            'form' => $form['form_blob'],
        ];

        return view('FormBuilder/form_builder', $data);
    }
}
