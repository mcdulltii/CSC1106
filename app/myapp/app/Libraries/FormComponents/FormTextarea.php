<?php

namespace App\Libraries\FormComponents;

class FormTextarea extends BaseComponent
{
    public static $count = 0;

    function __construct()
    {
        parent::__construct();
    }

    function render($field = '', $additionalAttr = array())
    {
        if ($field != '')
        {
            $html = array();

            $form_name = $field['input_type'] . '_' . $this::$count;
            $this->setAttribute('name', $form_name);

            foreach ($additionalAttr as $name => $value) {
                $this->setAttribute($name, $value);
            }

            $html['label'] = "<p>" . $field['label'] . "</p>";

            $html['textarea'] = '<textarea ';
            foreach ($this->getAttribute() as $name => $value) {
                $html['textarea'] .= ' ' . $name . '="' . $value . '"';
            }
            $html['textarea'] .= '>' . $field['value'] . '</textarea>';

            $html['row'] = $field['row'];
            $html['col'] = $field['col'];
            
            return $html;
        }

        return 'Render failed';
    }
}
