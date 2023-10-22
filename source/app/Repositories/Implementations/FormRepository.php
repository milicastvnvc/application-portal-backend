<?php

namespace App\Repositories\Implementations;

use App\Repositories\Interfaces\IFormRepository;
use Illuminate\Database\Eloquent\Model;

class FormRepository extends BaseRepository implements IFormRepository
{

    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findByApplicationId($application_id): ?Model
    {
        return $this->model
        ->where('application_id', $application_id)
        ->first();
    }
}
