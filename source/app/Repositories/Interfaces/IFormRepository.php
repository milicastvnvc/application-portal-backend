<?php

namespace App\Repositories\Interfaces;

interface IFormRepository extends IBaseRepository
{
    public function findByApplicationId($application_id);
}
