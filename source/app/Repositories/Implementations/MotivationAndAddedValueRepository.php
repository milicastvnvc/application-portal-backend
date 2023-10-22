<?php

namespace App\Repositories\Implementations;

use App\Models\MotivationAndAddedValue;
use App\Repositories\Interfaces\IMotivationAndAddedValueRepository;

class MotivationAndAddedValueRepository extends FormRepository implements IMotivationAndAddedValueRepository
{
    protected $model;

    public function __construct(MotivationAndAddedValue $model)
    {
        $this->model = $model;
    }
}
