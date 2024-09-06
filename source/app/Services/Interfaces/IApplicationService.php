<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface IApplicationService
{
    public function getById(Request $request): ActionResultResponse;

    public function getAllApplications(
        int $page = 1,
        string $search_key = '',
        $mobility_id = null,
        $home_institution_id = null,
        int $per_page = 10,
        $status = null): ActionResultResponse;

    public function getMyApplications(int $user_id): ActionResultResponse;

    public function create(Request $create_request): ActionResultResponse;

    public function submitApplication(Request $request): ActionResultResponse;

    public function changeApplicationStatus(Request $request): ActionResultResponse;

    public function validate(mixed $input_data, bool $create = true): Validator;

    public function deleteApplication($applicationId);

}
