<?php

namespace App\Repositories\Interfaces;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;

interface IApplicationRepository extends IBaseRepository
{
    public function getAllApplications(
        int $page = 1,
        string $search_key = '',
        mixed $mobility_id = null,
        mixed $home_institution_id = null,
        int $per_page = 10,
        mixed $status = null): mixed;

    public function getApplicationsByUser(int $user_id): Collection;

    public function getApplicationByIdAndUser(
        int $id,
        mixed $user,
        array $relations = [],
        bool $adminAccess = true): Application;

    public function deleteApplication($applicationId);
}
