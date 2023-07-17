<?php

namespace App\Libraries\FormComponents;

abstract class BaseComponent {
    protected $html;
    protected $attributes;
    protected $validationRules;

    function __construct()
    {
        $this->attributes = array();
        // $this->validationRules = array();
    }

    function setHtml($value)
    {
        $this->html .= $value;
    }

    function getHtml()
    {
        return $this->html;
    }

    function setAttribute($attr, $value)
    {
        $this->attributes[$attr] = $value;
    }

    function getAttribute()
    {
        return $this->attributes;
    }

    // check 2d-array
    function check_opts($options)
    {
        if (!is_array($options))
            return 'false';
        return count(array_filter($options, 'is_array')) === count($options);
    }

    abstract function render();
}