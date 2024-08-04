<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IApplicationProgressService;
use Illuminate\Http\Request;

class ApplicationProgressController extends Controller
{
    private $applicationProgressService;

    public function __construct(IApplicationProgressService $applicationProgressService)
    {
        $this->middleware('auth:api');
        $this->middleware('role:admin', ['only' => ['toggleLock']]);
        $this->applicationProgressService = $applicationProgressService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->applicationProgressService->getByApplicationId($request->application_id, $request->user());

        return response()->ok($response);
    }

    public function toggleLock(Request $request)
    {
        $response = $this->applicationProgressService->toggleLock($request);

        return response()->ok($response);
    }
}
