<?php

namespace App\Libraries\FormComponents;

class FormFieldset extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
        $this->count = session('formfieldset_count') ?? 0;
    }

    function check_Attr($attrs)
    {
        $commonAttributes = ["class", "name", "disabled"];
        $message = "Unsupported attributes for 'fieldset': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message
        );
    }

    function render($legend = '', $attrs = array())
    {
        $this->setAttribute('id', 'fieldset_' . $this->count);
        if ($attrs) {
            foreach ($attrs as $name => $value) {
                if (in_array($name, $this->booleanAttributes))
                    $this->setAttribute($name, true);
                else
                    $this->setAttribute($name, $value);
            }
        }

        $this->setHtml('<fieldset ');
        foreach ($this->getAttribute() as $name => $value) {
            if (in_array($name, $this->booleanAttributes))
                $this->setHtml(' ' . $name);
            else
                $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>');
        if ($legend)
            $this->setHtml('<legend>' . $legend . '</legend>');
        $this->setHtml('</fieldset>');

        session()->set('formfieldset_count', ++$this->count);

        return $this->getHtml();
    }
}
