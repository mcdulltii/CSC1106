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

    function check_Attr($attrs, $type)
    {
        $commonAttributes = ["class", "name", "disabled"];
        $buttonTypeAttributes = [
            "submit" => ["formaction", "formenctype", "formmethod", "formtarget"],
        ];
        $message = "Unsupported attributes for button type '$type': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message,
            $buttonTypeAttributes,
            $type
        );
    }

    function render($type = '', $btnVal = '', $attrs = array())
    {
        $this->setAttribute('type', $type);
        if ($attrs) {
            foreach ($attrs as $name => $value) {
                if (in_array($name, $this->booleanAttributes))
                    $this->setAttribute($name, true);
                else
                    $this->setAttribute($name, $value);
            }
        }

        $this->setHtml('<button');
        foreach ($this->getAttribute() as $name => $value) {
            if (in_array($name, $this->booleanAttributes))
                $this->setHtml(' ' . $name);
            else
                $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>' . $btnVal . '</button>');

        return $this->getHtml();
    }
}
