<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ISemesterRepository extends IBaseRepository
{
    public function getActiveSemesters(): Collection;
}
