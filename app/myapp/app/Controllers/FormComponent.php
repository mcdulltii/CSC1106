<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

use App\Libraries\FormComponents\FormInput;
use App\Libraries\FormComponents\FormSelect;
use App\Libraries\FormComponents\FormTextarea;
use App\Libraries\FormComponents\FormButton;
use App\Libraries\FormComponents\FormFieldset;

class FormComponent extends BaseController
{
    use ResponseTrait;

    public function index($tag)
    {
        $json = $this->request->getJSON(true);

        switch ($tag) {
            case "input":
                $component = new FormInput();
                $fields = [
                    'datalist' => '',
                ];

                if (isset($json["type"]) && $component->check_supported($json["type"])) {
                    if (isset($json["datalist"]) && $component->check_opts($json["datalist"]) == '')
                        $fields["datalist"] = $json["datalist"];
                    else
                        return $this->setResponseFormat('json')
                            ->fail('\'datalist\' field must be of type array');
                } else {
                    return $this->setResponseFormat('json')
                        ->fail('Input type is not supported');
                }

                $data['html'] = $component->render(
                    $json["label"],
                    $json["type"],
                    $fields["datalist"]
                );

                break;
            case "select":
                $component = new FormSelect();
                $fields = [
                    "optgroups" => '',
                    "options" => ''
                ];
                $failMessages = array(
                    'message' => 'Data parse failure',
                    'payloads' => array(
                        'type 1' => array(
                            'optgroups' => ['Group 1', 'Group 2', 'Group 3'],
                            'options' => [['1'], ['2'], ['3']]
                        ),
                        'type 2' => array(
                            'options' => ['1', '2', '3']
                        )
                    )
                );

                if (isset($json["optgroups"]) && isset($json["options"])) {
                    if (
                        is_array($json["optgroups"]) &&
                        $component->check_opts($json["options"]) == 1 &&
                        count($json["optgroups"]) == count($json["options"])
                    ) {
                        $fields["options"] = $json["options"];
                        $fields["optgroups"] = $json["optgroups"];
                    } else {
                        return $this->setResponseFormat('json')
                            ->fail($failMessages);
                    }
                } else if (
                    isset($json["options"]) &&
                    $component->check_opts($json["options"]) == ''
                ) {
                    $fields["options"] = $json["options"];
                } else {
                    return $this->setResponseFormat('json')
                        ->fail($failMessages);
                }

                $data['html'] = $component->render(
                    $json["label"],
                    $fields["options"],
                    $fields["optgroups"]
                );

                break;
            case "textarea":
                $component = new FormTextarea();
                $data["html"] = $component->render($json["label"], $tag);

                break;
            case "button":
                $component = new FormButton();

                if (isset($json["type"]) && $component->check_supported($json["type"])) {
                    $data["html"] = $component->render($json['type'], $json['value']);
                } else {
                    return $this->setResponseFormat('json')
                        ->fail('Button type is not supported');
                }

                break;
            case "fieldset":
                $component = new FormFieldset();
                $fields = [
                    'legend' => ''
                ];

                if (isset($json['legend']) && is_string($json['legend']))
                    $fields['legend'] = $json['legend'];
                else
                    return $this->setResponseFormat('json')
                        ->fail('\'legend\' field must be of type string');

                $data['html'] = $component->render($fields['legend']);

                break;
            default:
                return $this->setResponseFormat('json')
                    ->fail('Tag is not supported');
        }

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }
}
