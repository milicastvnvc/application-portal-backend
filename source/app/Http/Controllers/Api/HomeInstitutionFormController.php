<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IHomeInstitutionFormService;
use Illuminate\Http\Request;

class HomeInstitutionFormController extends Controller
{
    private $homeInstitutionFormService;

    public function __construct(IHomeInstitutionFormService $homeInstitutionFormService)
    {
        $this->middleware('auth:api');
        $this->homeInstitutionFormService = $homeInstitutionFormService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->homeInstitutionFormService->getByApplicationId($request->application_id, $request->user()->id);

        return response()->ok($response);
    }

    public function createOrUpdate(Request $request)
    {
        $response = $this->homeInstitutionFormService->createOrUpdate($request);

        return response()->ok($response);
    }
}
