<?php

namespace App\Libraries\FormComponents;

class FormButton extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
    }

    function check_supported($type)
    {
        $types = ["button", "submit", "reset"];
        
        if (in_array($type, $types))
            return 1; // true
        return 0;     // false
    }

    function render($type = '', $value = '')
    {
        $this->setAttribute('type', $type);
        $this->setAttribute('value', $value);

        $this->setHtml('<button');
        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>' . $value . '</button>');

        return $this->getHtml();
    }
}
