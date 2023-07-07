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

    function render($type = '')
    {
        $html = array();

        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        $this->setAttribute('value', '');

        if (!in_array($type, array('submit', 'reset'))) {
            $label = new FormLabel();
            $html['label'] = $label->render($form_name);
        }

        $html['input'] = '<input type="' . $type . '"';
        foreach ($this->getAttribute() as $name => $value) {
            $html['input'] .= ' ' . $name . '="' . $value . '"';
        }
        $html['input'] .= '>';

        $html['row'] = '';
        $html['col'] = '';

        session()->set('forminput_count', ++$this->count);

        return $html;
    }
}
