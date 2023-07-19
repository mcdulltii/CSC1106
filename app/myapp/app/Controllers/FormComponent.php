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
            case 'input':
                return $this->input($tag, $json);
            case 'select':
                return $this->select($tag, $json);
            case 'textarea':
                return $this->textarea($tag, $json);
            case 'button':
                return $this->button($tag, $json);
            case 'fieldset':
                return $this->fieldset($tag, $json);
            default:
                return $this->setResponseFormat('json')
                    ->fail('Tag is not supported');
        }
    }

    private function input($tag, $json)
    {
        $component = new FormInput();
        $fields = [
            'datalist' => '',
            'attributes' => '',
        ];

        if (isset($json['type']) && $component->check_supported($json['type'])) {
            if (isset($json['datalist']))
                if ($component->check_opts($json['datalist']) == '')
                    $fields['datalist'] = $json['datalist'];
                else
                    return $this->setResponseFormat('json')
                        ->fail('\'datalist\' field must be of type array');
        } else {
            return $this->setResponseFormat('json')
                ->fail('Input type is not supported');
        }

        $attrResponse = $this->check_attributes($tag, $component, $json);
        if (is_null($attrResponse)) {
        } else if (is_bool($attrResponse)) {
            $fields['attributes'] = $json['attributes'];
        } else {
            return $attrResponse;
        }

        $data['html'] = $component->render(
            $json['label'],
            $json['type'],
            $fields['datalist'],
            $fields['attributes']
        );

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }

    private function select($tag, $json)
    {
        $component = new FormSelect();
        $fields = [
            'optgroups' => '',
            'options' => ''
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

        if (isset($json['optgroups']) && isset($json['options'])) {
            if (
                is_array($json['optgroups']) &&
                $component->check_opts($json['options']) == 1 &&
                count($json['optgroups']) == count($json['options'])
            ) {
                $fields['options'] = $json['options'];
                $fields['optgroups'] = $json['optgroups'];
            } else {
                return $this->setResponseFormat('json')
                    ->fail($failMessages);
            }
        } else if (
            isset($json['options']) &&
            $component->check_opts($json['options']) == ''
        ) {
            $fields['options'] = $json['options'];
        } else {
            return $this->setResponseFormat('json')
                ->fail($failMessages);
        }

        $attrResponse = $this->check_attributes($tag, $component, $json);
        if (is_null($attrResponse)) {
        } else if (is_bool($attrResponse)) {
            $fields['attributes'] = $json['attributes'];
        } else {
            return $attrResponse;
        }

        $data['html'] = $component->render(
            $json['label'],
            $fields['options'],
            $fields['optgroups']
        );

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }

    private function textarea($tag, $json)
    {
        $component = new FormTextarea();
        $fields = [
            'attributes' => '',
        ];

        if (!isset($json['label']))
            return $this->setResponseFormat('json')
                ->fail('\'label\' value is required');

        $attrResponse = $this->check_attributes($tag, $component, $json);
        if (is_null($attrResponse)) {
        } else if (is_bool($attrResponse)) {
            $fields['attributes'] = $json['attributes'];
        } else {
            return $attrResponse;
        }

        $data['html'] = $component->render(
            $json['label'],
            $tag,
            $fields['attributes']
        );

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }

    private function button($tag, $json)
    {
        $component = new FormButton();
        $fields = [
            'attributes' => '',
        ];

        if (isset($json['type']) && $component->check_supported($json['type'])) {
            if (!isset($json['value']))
                return $this->setResponseFormat('json')
                    ->fail('Button value is required');
        } else {
            return $this->setResponseFormat('json')
                ->fail('Button type is not supported');
        }

        $attrResponse = $this->check_attributes($tag, $component, $json);
        if (is_null($attrResponse)) {
        } else if (is_bool($attrResponse)) {
            $fields['attributes'] = $json['attributes'];
        } else {
            return $attrResponse;
        }

        $data['html'] = $component->render(
            $json['type'],
            $json['value'],
            $fields['attributes']
        );

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }

    private function fieldset($tag, $json)
    {
        $component = new FormFieldset();
        $fields = [
            'legend' => '',
            'attributes' => '',
        ];

        if (isset($json['legend']) && is_string($json['legend']))
            $fields['legend'] = $json['legend'];
        else
            return $this->setResponseFormat('json')
                ->fail('\'legend\' field must be of type string');

        $attrResponse = $this->check_attributes($tag, $component, $json);
        if (is_null($attrResponse)) {
        } else if (is_bool($attrResponse)) {
            $fields['attributes'] = $json['attributes'];
        } else {
            return $attrResponse;
        }

        $data['html'] = $component->render(
            $fields['legend'],
            $fields['attributes']
        );

        return $this->setResponseFormat('json')
            ->respond(
                $data,
                200,
                'Successfully rendered'
            );
    }

    private function check_attributes($tag, $component, $json)
    {
        if (isset($json['attributes'])) {
            if (
                is_array($json['attributes']) &&
                count(array_filter(array_keys($json['attributes']), 'is_string')) > 0
            ) {
                if (in_array($tag, array('input', 'button')))
                    $check = $component->check_Attr($json['attributes'], $json['type']);
                else
                    $check = $component->check_Attr($json['attributes']);

                if (is_bool($check))
                    return true;
                else
                    return $this->setResponseFormat('json')
                        ->fail($check);
            } else {
                return $this->setResponseFormat('json')
                    ->fail('\'attributes\' field must be of type object');
            }
        }

        return;
    }
}
