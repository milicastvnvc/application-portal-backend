<?php

namespace App\Repositories\Implementations;

use App\Models\ApplicationProgress;
use App\Repositories\Interfaces\IApplicationProgressRepository;

class ApplicationProgressRepository extends FormRepository implements IApplicationProgressRepository
{
    protected $model;

    public function __construct(ApplicationProgress $model)
    {
        $this->model = $model;
    }

    public function updateWhereApplicationId($application_id, $payload)
    {
        return $this->model
        ->where('application_id', $application_id)
        ->update($payload);
    }
}
