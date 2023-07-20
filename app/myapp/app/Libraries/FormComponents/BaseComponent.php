<?php

namespace App\Libraries\FormComponents;

abstract class BaseComponent
{
    protected $html;
    protected $attributes;
    protected $booleanAttributes;
    protected $validationRules;

    function __construct()
    {
        $this->attributes = array();
        $this->booleanAttributes = [
            "readonly",
            "disabled",
            "required",
            "multiple",
        ];
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

    protected function check_additionalAttr(
        $commonAttributes,
        $attrs,
        $message,
        $typeAttributes = array(),
        $type = ''
    ) {
        $supportedAttributes = array_merge($commonAttributes, $typeAttributes[$type] ?? []);
        $unsupportedAttributes = array_diff(array_keys($attrs), $supportedAttributes);

        if (!empty($unsupportedAttributes)) {
            $errMessage = [
                "error" => $message . implode(', ', $unsupportedAttributes),
                "message" => "Supported attributes are: " . implode(', ', $supportedAttributes),
            ];

            return $errMessage;
        } else {
            return true;
        }
    }

    abstract function render();
}
