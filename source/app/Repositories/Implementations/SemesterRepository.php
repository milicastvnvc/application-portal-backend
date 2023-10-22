<?php

namespace App\Repositories\Implementations;

use App\Models\Semester;
use App\Repositories\Interfaces\ISemesterRepository;

class SemesterRepository extends BaseRepository implements ISemesterRepository
{
    protected $model;

    public function __construct(Semester $model)
    {
        $this->model = $model;
    }

    public function getActiveSemesters()
    {
        return $this->model->where('is_active', true)->get();
    }
}
