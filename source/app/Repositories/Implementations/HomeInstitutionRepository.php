<?php

namespace App\Repositories\Implementations;

use App\Models\HomeInstitution;
use App\Repositories\Interfaces\IHomeInstitutionRepository;

class HomeInstitutionRepository extends BaseRepository implements IHomeInstitutionRepository
{
    protected $model;

    public function __construct(HomeInstitution $model)
    {
        $this->model = $model;
    }

    public function getAllHomeInstitutions()
    {
        return $this->model->get();
    }
}
