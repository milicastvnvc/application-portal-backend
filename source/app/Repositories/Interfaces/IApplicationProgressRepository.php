<?php

namespace App\Repositories\Interfaces;

interface IApplicationProgressRepository extends IFormRepository
{
    public function updateWhereApplicationId($application_id, array $payload);
}
