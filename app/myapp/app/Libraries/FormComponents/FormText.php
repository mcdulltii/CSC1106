<?php

namespace App\Libraries\FormComponents;

class FormText extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
        $this->count = session('formtext_count') ?? 0;
    }

    function check_supported($heading)
    {
        $headings = [
            "p",
            "h1",
            "h2",
            "h3"
        ];

        if (in_array($heading, $headings))
            return 1; // true
        return 0;     // false
    }

    function check_Attr($attrs)
    {
        $commonAttributes = ["class", "name"];
        $message = "Unsupported attributes for 'text': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message
        );
    }

    function render($type = '', $heading = '', $text = '', $attrs = array())
    {
        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        if ($attrs) {
            foreach ($attrs as $name => $value) {
                if (in_array($name, $this->booleanAttributes))
                    $this->setAttribute($name, true);
                else
                    $this->setAttribute($name, $value);
            }
        }

        $this->setHtml('<' . $heading);

        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }

        $this->setHtml('>' . $text . '</' . $heading . '>');

        session()->set('formtext_count', ++$this->count);

        return $this->getHtml();
    }
}
