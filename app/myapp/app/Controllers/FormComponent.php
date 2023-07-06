<?php

namespace App\Controllers;

use App\Libraries\FormComponents\FormInput;
use App\Libraries\FormComponents\FormTextarea;

class FormComponent extends BaseController
{
    public function index()
    {
        helper('form');

        $data = array();

        if ($this->request->is('post')) {
            $post = $this->request->getPost([
                'input_type',
                'label',
                'value',
                'row',
                'col',
            ]);

            switch ($post['input_type'])
            {
                case "textarea":
                    $component = new FormTextarea();
                    $additionalAttr = $this->request->getPost([
                        'rows',
                        'cols',
                    ]);
                    $data['component'] = $component->render($post, $additionalAttr);
                    break;
                default: // input case
                    $component = new FormInput();
                    if ($component->supported($post['input_type']))
                        $data['component'] = $component->render($post);
                    break;
            }

            return view('form/index', $data);
        }

        return view('form/index');
    }
}
