<?php

namespace App\Libraries\FormComponents;

class FormLabel extends BaseComponent
{
    function __construct()
    {
        parent::__construct();
    }

    function render($form_name = '')
    {
        $html = '<label for="' . $form_name . '"';

        foreach ($this->getAttribute() as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }

        $html .= '>' . $form_name . '</label>';
        
        return $html;
    }
}
