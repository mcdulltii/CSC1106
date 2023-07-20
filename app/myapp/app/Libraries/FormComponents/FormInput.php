<?php

namespace App\Libraries\FormComponents;

use App\Libraries\FormComponents\FormLabel;

class FormInput extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
        $this->count = session('forminput_count') ?? 0;
    }

    function check_supported($type)
    {
        $types = [
            "button",
            "checkbox",
            "color",
            "date",
            "datetime-local",
            "email",
            "file",
            "hidden",
            "image",
            "month",
            "number",
            "password",
            "radio",
            "range",
            "reset",
            "search",
            "submit",
            "tel",
            "text",
            "time",
            "url",
            "week"
        ];

        if (in_array($type, $types))
            return 1; // true
        return 0;     // false
    }

    function check_Attr($attrs, $type)
    {
        $commonAttributes = ["class", "value", "disabled"];
        $inputTypeAttributes = [
            "checkbox" => ["required", "checked"],
            "date" => ["min", "max", "pattern", "step"],
            "datetime-local" => ["min", "max", "step"],
            "email" => ["size", "multiple", "pattern", "placeholder", "required"],
            "file" => ["multiple", "required"],
            "image" => ["alt", "height", "width"],
            "month" => ["min", "max", "step"],
            "number" => ["min", "max", "required", "step"],
            "password" => ["size", "pattern", "placeholder", "required"],
            "radio" => ["required"],
            "range" => ["min", "max", "step"],
            "search" => ["size", "pattern", "placeholder", "required"],
            "tel" => ["size", "pattern", "placeholder", "required"],
            "text" => ["readonly", "size", "pattern", "placeholder", "required"],
            "time" => ["min", "max", "step"],
            "url" => ["size", "pattern", "placeholder", "required"],
            "week" => ["min", "max", "step"]
        ];
        $message = "Unsupported attributes for input type '$type': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message,
            $inputTypeAttributes,
            $type
        );
    }

    function render($lbl = '', $type = '', $datalist = array(), $attrs = array())
    {
        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        if ($attrs) {
            foreach ($attrs as $name => $value) {
                if (in_array($name, $this->booleanAttributes))
                    $this->setAttribute($name, true);
                else
                    $this->setAttribute($name, $value);
            }
        }
        if ($datalist) {
            $this->setAttribute('list', $form_name . '_list');
        }

        if (!in_array($type, array('submit', 'reset'))) {
            $label = new FormLabel();
            $this->setHtml($label->render($form_name, $lbl));
        }

        $this->setHtml('<input type="' . $type . '"');
        foreach ($this->getAttribute() as $name => $value) {
            if (in_array($name, $this->booleanAttributes))
                $this->setHtml(' ' . $name);
            else
                $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>');

        if ($datalist) {
            $this->setHtml('<datalist id="' . $form_name . '_list">');
            foreach ($datalist as $data) {
                $this->setHtml('<option value="' . $data . '">');
            }
            $this->setHtml('</datalist>');
        }

        session()->set('forminput_count', ++$this->count);

        return $this->getHtml();
    }
}
