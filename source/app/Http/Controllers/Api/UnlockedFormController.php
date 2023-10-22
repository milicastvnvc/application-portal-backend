<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IUnlockedFormService;
use Illuminate\Http\Request;

class UnlockedFormController extends Controller
{

    private $unlockedFormService;

    public function __construct(IUnlockedFormService $unlockedFormService)
    {
        $this->middleware('auth:api');
        $this->middleware('role:admin');
        $this->unlockedFormService = $unlockedFormService;
    }

    public function getUnlockedForm(Request $request)
    {
        $response = $this->unlockedFormService->getUnlockedForm($request->application_id, $request->form_name);

        return response()->ok($response);
    }

    public function toggleLock(Request $request)
    {
        $response = $this->unlockedFormService->toggleLock($request);

        return response()->ok($response);
    }
}
