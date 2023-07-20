<?php

namespace App\Libraries\FormComponents;

class FormText extends BaseComponent
{
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

    function render($type = '', $heading = '', $text = '')
    {
        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setHtml('<' . $heading . ' for="' . $form_name . '"');

        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }

        $this->setHtml('>' . $text . '</' . $heading . '>');

        session()->set('formtext_count', ++$this->count);

        return $this->getHtml();
    }
}
