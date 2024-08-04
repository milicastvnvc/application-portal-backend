<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface IUploadedDocumentsService
{
    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse;

    public function createOrUpdate(Request $request): ActionResultResponse;

    public function download(Request $request): null|string;

    public function downloadAll(Request $request): null|string;

    public function validate(mixed $input_data, string $file_formats): Validator;
}
