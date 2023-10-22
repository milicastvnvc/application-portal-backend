<?php

namespace App\Services\Interfaces;

interface IMotivationAndAddedValueService
{
    public function getByApplicationId($application_id, $user_id);

    public function createOrUpdate($request);

    public function validate($input_data);
}
