<?php

namespace App\Repositories\Implementations;

use App\Models\HomeInstitutionForm;
use App\Repositories\Interfaces\IHomeInstitutionFormRepository;

class HomeInstitutionFormRepository extends FormRepository implements IHomeInstitutionFormRepository
{
    protected $model;

    public function __construct(HomeInstitutionForm $model)
    {
        $this->model = $model;
    }
}
