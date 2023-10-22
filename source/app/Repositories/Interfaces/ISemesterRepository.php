<?php

namespace App\Repositories\Interfaces;

interface ISemesterRepository extends IBaseRepository
{
    public function getActiveSemesters();
}
