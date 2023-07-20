<?php

namespace App\Libraries\FormComponents;

class FormTextarea extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
        $this->count = session('formtextarea_count') ?? 0;
    }

    function check_Attr($attrs)
    {
        $commonAttributes = [
            "class",
            "name",
            "disabled",
            "rows",
            "cols",
            "placeholder",
            "readonly",
            "required",
        ];
        $message = "Unsupported attributes for 'textarea': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message
        );
    }

    function render($lbl = '', $type = '', $attrs = array())
    {
        $label = new FormLabel();

        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        if ($attrs) {
            foreach ($attrs as $name => $value) {
                if (in_array($name, $this->booleanAttributes))
                    $this->setAttribute($name, true);
                else
                    $this->setAttribute($name, $value);
            }
        }

        $this->setHtml($label->render($form_name, $lbl));

        $this->setHtml('<textarea ');
        foreach ($this->getAttribute() as $name => $value) {
            if (in_array($name, $this->booleanAttributes))
                $this->setHtml(' ' . $name);
            else
                $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('></textarea>');

        session()->set('formtextarea_count', ++$this->count);

        return $this->getHtml();
    }
}
