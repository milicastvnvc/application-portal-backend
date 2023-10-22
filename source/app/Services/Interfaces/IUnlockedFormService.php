<?php

namespace App\Services\Interfaces;

interface IUnlockedFormService
{
    public function getUnlockedForm($application_id, $form_name);

    public function toggleLock($request);

    public function unlockForm($application, $form_name);

    public function lockForm($application, $form_name);

    public function validate($input_data);
}
