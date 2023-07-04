<?php

require_once('FormInput.php');

function input_text()
{
    $type = 'text';
    $form_text = new FormInput($type);
    
    print($form_text->render() . "\n");
}

function input_checkbox($value)
{
    $type = 'checkbox';
    $form_text = new FormInput($type);

    print($form_text->render(array('value'=>$value)));
}

input_text();
input_checkbox('Bike');