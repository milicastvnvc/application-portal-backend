<?php

namespace App\Repositories\Implementations;

use App\Models\ProposedHostUniversities;
use App\Repositories\Interfaces\IProposedHostUniversitiesRepository;

class ProposedHostUniversitiesRepository extends FormRepository implements IProposedHostUniversitiesRepository
{
    protected $model;

    public function __construct(ProposedHostUniversities $model)
    {
        $this->model = $model;
    }

}
