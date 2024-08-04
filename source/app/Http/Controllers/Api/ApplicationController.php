<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\IApplicationService;

class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(IApplicationService $applicationService)
    {
        $this->middleware('auth:api');
        $this->middleware('role:admin', ['only' => ['getAllApplications', 'changeApplicationStatus']]);
        $this->applicationService = $applicationService;
    }

    public function getById(Request $request)
    {
        $response = $this->applicationService->getById($request);

        return response()->ok($response);
    }

    public function getAllApplications(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $status = $request->input('status', null);
        $search_key = $request->input('search_key', '');
        $mobility_id = $request->input('mobility_id', null);
        $home_institution_id = $request->input('home_institution_id', null);

        $response = $this->applicationService->getAllApplications($page, $search_key, $mobility_id, $home_institution_id, $per_page, $status);

        return response()->ok($response);
    }

    public function getMyApplications(Request $request)
    {
        $response = $this->applicationService->getMyApplications($request->user()->id);

        return response()->ok($response);
    }

    public function create(Request $create_request)
    {
        $response = $this->applicationService->create($create_request);

        return response()->ok($response);
    }

    public function submitApplication(Request $request)
    {
        $response = $this->applicationService->submitApplication($request);

        return response()->ok($response);
    }

    public function changeApplicationStatus(Request $request)
    {
        $response = $this->applicationService->changeApplicationStatus($request);

        return response()->ok($response);
    }
}
