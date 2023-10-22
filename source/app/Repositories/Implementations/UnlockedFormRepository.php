<?php

namespace App\Repositories\Implementations;

use App\Models\UnlockedForm;
use App\Repositories\Interfaces\IUnlockedFormRepository;

class UnlockedFormRepository extends BaseRepository implements IUnlockedFormRepository
{
    protected $model;

    public function __construct(UnlockedForm $model)
    {
        $this->model = $model;
    }

    public function findByApplicationIdAndFormName($applicayion_id, $form_name)
    {
        return $this->model
        ->where('application_id', $applicayion_id)
        ->where('form_name', $form_name)
        ->first();
    }

    public function countByApplicationId($application_id)
    {
        return $this->model
        ->where('application_id', $application_id)
        ->count();
    }
}
