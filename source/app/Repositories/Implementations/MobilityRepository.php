<?php

namespace App\Repositories\Implementations;

use App\Models\Mobility;
use App\Repositories\Interfaces\IMobilityRepository;

class MobilityRepository extends BaseRepository implements IMobilityRepository
{
    protected $model;

    public function __construct(Mobility $model)
    {
        $this->model = $model;
    }
}
