<?php


namespace App\ViewModels;

class FormResponse
{

    public $form;
    public $application;

    public function __construct($form, $application)
    {
        $this->form = $form;
        $this->application = new ApplicationViewModel($application);
    }
}
