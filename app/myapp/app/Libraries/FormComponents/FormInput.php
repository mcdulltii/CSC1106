<?php

namespace App\Libraries\FormComponents;

use App\Libraries\FormComponents\FormLabel;

class FormInput extends BaseComponent
{
    public static $count = 0;

    function __construct()
    {
        parent::__construct();
    }

    function supported($type)
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

    function render($field = '')
    {
        if ($field != '') {
            $html = array();

            $form_name = $field['input_type'] . '_' . $this::$count;
            $this->setAttribute('id', $form_name);
            $this->setAttribute('name', $form_name);
            $this->setAttribute('value', $field['value']);

            if (!in_array($field['input_type'], array('submit', 'reset'))) {
                $label = new FormLabel($form_name, $field['label']);
                $html['label'] = $label->render();
            }

            $html['input'] = '<input type="' . $field['input_type'] . '"';
            foreach ($this->getAttribute() as $name => $value) {
                $html['input'] .= ' ' . $name . '="' . $value . '"';
            }
            $html['input'] .= '>';

            $html['row'] = $field['row'];
            $html['col'] = $field['col'];

            return $html;
        }

        return 'Render failed';
    }
}
