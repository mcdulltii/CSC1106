<?php

namespace App\Libraries\FormComponents;

use App\Libraries\FormComponents\FormLabel;

class FormSelect extends BaseComponent
{
    protected $count;

    function __construct()
    {
        parent::__construct();
        $this->count = session('formselect_count') ?? 0;
    }

    private function generate_options($options, $optgroups)
    {
        $html = '';
        $count = count($options);

        if ($optgroups) {
            for ($i = 0; $i < $count; $i++) {
                $html .= '<optgroup label="' . $optgroups[$i] . '">';

                foreach ($options[$i] as $option) {
                    $html .= '<option value="' . $option . '">' . $option . '</option>';
                }

                $html .= '</optgroup>';
            }
        } else {
            foreach ($options as $option) {
                $html .= '<option value="' . $option . '">' . $option . '</option>';
            }
        }

        return $html;
    }

    function check_Attr($attrs)
    {
        $commonAttributes = ["class", "name", "disabled", "multiple", "required"];
        $message = "Unsupported attributes for 'select': ";

        return $this->check_additionalAttr(
            $commonAttributes,
            $attrs,
            $message
        );
    }

    function render($lbl = '', $options = '', $optgroups = '', $attrs = array())
    {
        $form_name = 'select_' . $this->count;
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

        $label = new FormLabel();
        $this->setHtml($label->render($form_name, $lbl));

        $this->setHtml('<select');
        foreach ($this->getAttribute() as $name => $value) {
            if (in_array($name, $this->booleanAttributes))
                $this->setHtml(' ' . $name);
            else
                $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>');
        $this->setHtml($this->generate_options($options, $optgroups));
        $this->setHtml('</select>');

        session()->set('formselect_count', ++$this->count);

        return $this->getHtml();
    }
}
