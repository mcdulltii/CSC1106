<?php

require_once('FormComponent.php');

class FormInput extends FormComponent
{
    public static $count = 0;
    protected $type;

    function __construct($type)
    {
        parent::__construct();
        $this->type = $type;
    }

    function render($additionalAttr = array())
    {
        $attr = array();
        $attr['id'] = $attr['name'] = $this->type . '_' . $this::$count;
        $this->setAttribute(array_merge($attr, $additionalAttr));

        $html = '<input type="' . $this->type . '"';

        foreach ($this->getAttribute() as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }

        $html .= '>';

        return $html;
    }
}
