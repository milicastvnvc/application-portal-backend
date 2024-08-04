<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface IFormRepository extends IBaseRepository
{
    public function findByApplicationId(int $application_id): ?Model;
}
