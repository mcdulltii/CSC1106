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

    function render($lbl = '', $options = '', $optgroups = '')
    {
        $form_name = 'select_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);

        $label = new FormLabel();
        $this->setHtml($label->render($form_name, $lbl));

        $this->setHtml('<select');
        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('>');
        $this->setHtml($this->generate_options($options, $optgroups));
        $this->setHtml('</select>');

        session()->set('formselect_count', ++$this->count);

        return $this->getHtml();
    }
}
