<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\IPersonalDetailsService;

class PersonalDetailsController extends Controller
{
    private $personalDetailsService;

    public function __construct(IPersonalDetailsService $personalDetailsService)
    {
        $this->middleware('auth:api');
        $this->personalDetailsService = $personalDetailsService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->personalDetailsService->getByApplicationId($request->application_id, $request->user());

        return response()->ok($response);
    }

    public function createOrUpdate(Request $request)
    {
        $response = $this->personalDetailsService->createOrUpdate($request);

        return response()->ok($response);
    }
}
