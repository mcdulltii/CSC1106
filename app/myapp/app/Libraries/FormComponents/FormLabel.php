<?php

namespace App\Libraries\FormComponents;

class FormLabel extends BaseComponent
{
    function __construct()
    {
        parent::__construct();
    }

    function render($form_name = '', $value = '')
    {
        $this->setHtml('<label for="' . $form_name . '"');

        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }

        $this->setHtml('>' . $value . '</label>');
        
        return $this->getHtml();
    }
}
