<?php

namespace App\Services\Interfaces;

use App\Models\Application;

interface IApplicationService
{
    public function getById($request);

    public function getAllApplications($page = 1, $search_key = '', $mobility_id = null, $home_institution_id = null, $per_page = 10, $is_submitted = true);

    public function getMyApplications($user_id);

    public function create($create_request);

    public function submitApplication($request);

    public function validate($input_data);
}
