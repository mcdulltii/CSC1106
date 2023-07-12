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

    abstract function render();
}