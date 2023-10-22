<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IDocumentTypeService;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    private $documentTypeService;

    public function __construct(IDocumentTypeService $documentTypeService)
    {
        $this->middleware('auth:api');
        $this->documentTypeService = $documentTypeService;
    }

    public function getByMobilityType(Request $request)
    {
        $response = $this->documentTypeService->getByMobilityType($request);

        return response()->ok($response);
    }
}
