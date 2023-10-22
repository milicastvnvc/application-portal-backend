<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IProposedHostUniversitiesService;
use Illuminate\Http\Request;

class ProposedHostUniversitiesController extends Controller
{
    private $proposedHostUniversitiesService;

    public function __construct(IProposedHostUniversitiesService $proposedHostUniversitiesService)
    {
        $this->middleware('auth:api');
        $this->proposedHostUniversitiesService = $proposedHostUniversitiesService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->proposedHostUniversitiesService->getByApplicationId($request->application_id, $request->user()->id);

        return response()->ok($response);
    }

    public function createOrUpdate(Request $request)
    {
        $response = $this->proposedHostUniversitiesService->createOrUpdate($request);

        return response()->ok($response);
    }
}
