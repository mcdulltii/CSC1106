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

    function render($legend = '')
    {
        $this->setHtml('<fieldset ' . 'id= "' . $this->count . '">');

        if ($legend)
            $this->setHtml('<legend>' . $legend . '</legend>');

        $this->setHtml('</fieldset>');
        session()->set('formfieldset_count', ++$this->count);

        return $this->getHtml();
    }
}
