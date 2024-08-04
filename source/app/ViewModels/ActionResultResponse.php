<?php


namespace App\ViewModels;

class ActionResultResponse
{

    public $success;
    public $data;
    public $errors;

    function setSuccess(mixed $data)
    {
        $this->success = true;
        $this->data = $data;
        $this->errors = [];
    }

    function setErrors(array $errors, $data = NULL)
    {
        $this->success = false;
        $this->data = $data;
        $this->errors = $errors;
    }
}
