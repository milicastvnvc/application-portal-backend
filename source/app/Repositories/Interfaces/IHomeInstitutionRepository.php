<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IHomeInstitutionRepository extends IBaseRepository
{
    public function getAllHomeInstitutions(): Collection;
}
