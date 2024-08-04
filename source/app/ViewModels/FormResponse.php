<?php


namespace App\ViewModels;

use App\Models\Application;
use Illuminate\Database\Eloquent\Model;

class FormResponse
{

    public $form;
    public $application;

    public function __construct(?Model $form, Application $application)
    {
        $this->form = $form;
        $this->application = new ApplicationViewModel($application);
    }
}
