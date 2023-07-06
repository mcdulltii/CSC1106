<?php

namespace App\Libraries\FormComponents;

abstract class BaseComponent {
    protected $attributes;
    protected $validationRules;

    function __construct()
    {
        $this->attributes = array();
        // $this->validationRules = array();
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