<?php

namespace App\Repositories\Implementations;

use App\Models\OtherMobility;
use App\Repositories\Interfaces\IOtherMobilityRepository;

class OtherMobilityRepository extends FormRepository implements IOtherMobilityRepository
{
    protected $model;

    public function __construct(OtherMobility $model)
    {
        $this->model = $model;
    }
}
