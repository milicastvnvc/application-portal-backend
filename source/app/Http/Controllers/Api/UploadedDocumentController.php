<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\IUploadedDocumentsService;
use Illuminate\Http\Request;

class UploadedDocumentController extends Controller
{
    private $uploadedDocumentService;

    public function __construct(IUploadedDocumentsService $uploadedDocumentService)
    {
        $this->middleware('auth:api');
        $this->uploadedDocumentService = $uploadedDocumentService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->uploadedDocumentService->getByApplicationId($request->application_id, $request->user()->id);

        return response()->ok($response);
    }

    public function createOrUpdate(Request $request)
    {
        $response = $this->uploadedDocumentService->createOrUpdate($request);

        return response()->ok($response);
    }

    public function download(Request $request)
    {
        $file_path = $this->uploadedDocumentService->download($request);

        if (!$file_path) response()->notFound();

        return response()->download($file_path);
    }
}
