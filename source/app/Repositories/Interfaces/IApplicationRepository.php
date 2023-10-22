<?php

namespace App\Repositories\Interfaces;

interface IApplicationRepository extends IBaseRepository
{
    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $is_submitted = true);

    public function getApplicationsByUser($user_id);

    public function getApplicationByIdAndUser($id, $user_id, array $relations = [], $adminAccess = true);
}
