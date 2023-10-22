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
        $this->applicationProgressService = $applicationProgressService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->applicationProgressService->getByApplicationId($request->application_id);

        return response()->ok($response);
    }
}
