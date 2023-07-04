<?php

abstract class FormComponent {
    protected $attributes;
    protected $validationRules;

    function __construct()
    {
        $this->attributes = array();
        // $this->validationRules = array();
    }

    function setAttribute($attr)
    {
        $this->attributes = $attr;
    }

    function getAttribute()
    {
        return $this->attributes;
    }

    abstract function render();
}