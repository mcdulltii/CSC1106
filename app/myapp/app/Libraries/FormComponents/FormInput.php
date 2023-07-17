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
        $types = ["button",
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

    function render($lbl = '', $type = '', $datalist = array())
    {
        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        $this->setAttribute('value', '');
        if ($datalist)
        {
            $this->setAttribute('list', $form_name . '_list');
        }

        if (!in_array($type, array('submit', 'reset'))) {
            $label = new FormLabel();
            $this->setHtml($label->render($form_name, $lbl));
        }

        $this->setHtml('<input type="' . $type . '"');
        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>');

        if ($datalist)
        {
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
