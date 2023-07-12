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

    function render($lbl = '', $type = '')
    {
        $label = new FormLabel();

        $form_name = $type . '_' . $this->count;
        $this->setAttribute('id', $form_name);
        $this->setAttribute('name', $form_name);
        $this->setAttribute('rows', '5');
        $this->setAttribute('cols', '15');

        $this->setHtml($label->render($form_name, $lbl));

        $this->setHtml('<textarea ');
        foreach ($this->getAttribute() as $name => $value) {
            $this->setHtml(' ' . $name . '="' . $value . '"');
        }
        $this->setHtml('></textarea>');

        session()->set('formtextarea_count', ++$this->count);

        return $this->getHtml();
    }
}
