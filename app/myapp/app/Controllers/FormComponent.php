<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

use App\Libraries\FormComponents\FormInput;
use App\Libraries\FormComponents\FormTextarea;

class FormComponent extends BaseController
{
    use ResponseTrait;

    public function index($tag, $type = '')
    {
        switch($tag)
        {
            case "input":
                $component = new FormInput();
                
                if ($component->check_supported($type))
                {
                    $data = $component->render($type);
                }
                else
                {
                    return $this->setResponseFormat('json')
                                ->fail('Input type is not supported');
                }
                break;
            case "textarea":
                $component = new FormTextarea();
                $data = $component->render($tag);
                break;
            default:
                return $this->setResponseFormat('json')
                             ->fail('Input type is not supported');
        }

        return $this->setResponseFormat('json')
                    ->respond(
                        $data,
                        200,
                        'Successfully rendered'
                    );
    }

    public function view()
    {
        return view("form/index");
    }
}
