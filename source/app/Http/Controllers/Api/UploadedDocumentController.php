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
        $this->middleware('role:admin', ['only' => ['downloadAll']]);
        $this->uploadedDocumentService = $uploadedDocumentService;
    }

    public function getByApplicationId(Request $request)
    {
        $response = $this->uploadedDocumentService->getByApplicationId($request->application_id, $request->user());

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

        if (!$file_path) return response()->notFound();

        return response()->download($file_path);
    }

    public function downloadAll(Request $request)
    {
        $file_path = $this->uploadedDocumentService->downloadAll($request);

        if (!$file_path) return response()->notFound();

        return response()->download($file_path)->deleteFileAfterSend(true);
    }
}
