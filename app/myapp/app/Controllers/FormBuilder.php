<?php

namespace App\Controllers;

use Dompdf\Dompdf;

use App\Controllers\BaseController;

class FormBuilder extends BaseController
{
    private $encrypter;
    private $session;

    public function __construct()
    {
        $this->encrypter = \Config\Services::encrypter();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $uid = $this->session->get('user_id');

        if (!$uid) {
            return redirect('register', 'refresh');
        } else {
            // Clear the form ID from the session to ensure form builder starts fresh
            $this->session->set('form_id', null);
            return view('FormBuilder/form_builder', ['form' => null]);
        }
    }

    public function saveForm()
    {
        $jsonPayload = $this->request->getJSON();
        $id = $this->session->get('form_id') ?? null;

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
                    'user_id' => $this->session->get('user_id'),
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
        $this->session->set('form_id', $id);

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

    public function exportForm($id)
    {
        // Set the form ID in the session so the form builder knows which form to load and update
        $this->session->set('form_id', $id);

        // Get the form from the database
        $formModel = model(FormModel::class);
        $form = $formModel->getForm($id);

        $uncompressed_data = gzdecode($form['form_blob']);
        $decrypted_data = $this->encrypter->decrypt($uncompressed_data);

        $data = [
            'form' => $decrypted_data,
        ];

        if (! $this->request->is('post')) {
            return view('FormBuilder/form_export', $data);
        }

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml(view('FormBuilder/form_export', $data));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}
