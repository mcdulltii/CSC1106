<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class FormBuilder extends BaseController
{
    private $encrypter;

    public function __construct()
    {
        $this->encrypter = \Config\Services::encrypter();
    }

    public function index()
    {
        $session = \Config\Services::session();
        $uid = $session->get('user_id');

        if (!$uid) {
            return redirect('register', 'refresh');
        } else {
            // Clear the form ID from the session to ensure form builder starts fresh
            $_SESSION['form_id'] = null;
            return view('FormBuilder/form_builder', ['form' => null]);
        }
    }

    public function saveForm()
    {
        $jsonPayload = $this->request->getJSON();
        $id = $_SESSION['form_id'] ?? null;

        $formModel = model(FormModel::class);

        $encrypted_data = $this->encrypter->encrypt($jsonPayload->formData);
        $compressed_data = gzencode($encrypted_data, 9);

        try {
            // If the form has an ID, update it, otherwise create a new one
            if ($id) {
                $formModel->updateForm($id, [
                    'form_blob' => $compressed_data
                ]);
            }
            else {
                $formModel->save([
                    'form_blob' => $compressed_data,
                    'user_id' => $_SESSION['user_id'],
                ]);
            }
            return $this->response->setJSON(['success' => true]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function editForm($id)
    {
        // Set the form ID in the session so the form builder knows which form to load and update
        $_SESSION['form_id'] = $id;

        // Get the form from the database
        $formModel = model(FormModel::class);
        $form = $formModel->getForm($id);

        $uncompressed_data = gzdecode($form['form_blob']);
        $decrypted_data = $this->encrypter->decrypt($uncompressed_data);

        $data = [
            'form' => $decrypted_data,
        ];

        return view('FormBuilder/form_builder', $data);
    }
}
