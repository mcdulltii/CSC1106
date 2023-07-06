<?php

namespace App\Libraries\FormComponents;

class FormLabel extends BaseComponent
{
    public static $count = 0;
    protected $for_attr;
    protected $title;

    function __construct($for_attr, $title)
    {
        parent::__construct();
        $this->for_attr = $for_attr;
        $this->title = $title;
    }

    function render()
    {
        $html = '<label for="' . $this->for_attr . '"';

        foreach ($this->getAttribute() as $name => $value) {
            $html .= ' ' . $name . '="' . $value . '"';
        }

        $html .= '>' . $this->title . '</label>';
        
        return $html;
    }
}
