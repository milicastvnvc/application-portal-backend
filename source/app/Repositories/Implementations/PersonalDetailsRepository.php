<?php

namespace App\Repositories\Implementations;

use App\Models\PersonalDetails;
use App\Repositories\Interfaces\IPersonalDetailsRepository;

class PersonalDetailsRepository extends FormRepository implements IPersonalDetailsRepository
{
    protected $model;

    public function __construct(PersonalDetails $model)
    {
        $this->model = $model;
    }
}
