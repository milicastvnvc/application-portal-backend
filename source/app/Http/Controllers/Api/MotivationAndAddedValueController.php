<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IMotivationAndAddedValueService;
use Illuminate\Http\Request;


class MotivationAndAddedValueController extends Controller
{
    private $motivationAndAddedValueService;

    public function __construct(IMotivationAndAddedValueService $motivationAndAddedValueService)
    {
        $this->middleware('auth:api');
        $this->motivationAndAddedValueService = $motivationAndAddedValueService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->motivationAndAddedValueService->getByApplicationId($request->application_id, $request->user()->id);

        return response()->ok($response);
    }

    public function createOrUpdate(Request $request)
    {
        $response = $this->motivationAndAddedValueService->createOrUpdate($request);

        return response()->ok($response);
    }
}
