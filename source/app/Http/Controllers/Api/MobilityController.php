<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IMobilityService;

class MobilityController extends Controller
{
    private $mobilityService;

    public function __construct(IMobilityService $mobilityService)
    {
        $this->middleware('auth:api');
        $this->mobilityService = $mobilityService;
    }

    public function getAll()
    {
        $response = $this->mobilityService->getAll();

        return response()->ok($response);
    }
}
