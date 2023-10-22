<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IHomeInstitutionService;
use Illuminate\Http\Request;

class HomeInstitutionController extends Controller
{
    private $homeInsitutionService;

    public function __construct(IHomeInstitutionService $homeInsitutionService)
    {
        $this->middleware('auth:api');
        $this->homeInsitutionService = $homeInsitutionService;
    }

    public function getById(Request $request)
    {
        $response = $this->homeInsitutionService->getById($request);

        return response()->ok($response);
    }

    public function getAll()
    {
        $response = $this->homeInsitutionService->getAll();

        return response()->ok($response);
    }

    public function create(Request $request)
    {
        $response = $this->homeInsitutionService->create($request);

        return response()->ok($response);
    }
}
