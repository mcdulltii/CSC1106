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

    function render($type = '')
    {
        $html = array();
        $label = new FormLabel();

        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        $this->setAttribute('rows', '5');
        $this->setAttribute('cols', '15');

        $html['label'] = $label->render($form_name);

        $html['textarea'] = '<textarea ';
        foreach ($this->getAttribute() as $name => $value) {
            $html['textarea'] .= ' ' . $name . '="' . $value . '"';
        }
        $html['textarea'] .= '></textarea>';

        session()->set('formtextarea_count', ++$this->count);

        return $html;
    }
}
