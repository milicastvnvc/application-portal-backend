<?php

namespace App\Services\Interfaces;

use App\Models\ApplicationProgress;
use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface IApplicationProgressService
{
    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse;

    public function toggleLock(Request $request): ActionResultResponse;

    public function unlockForm(ApplicationProgress $progress, string $form_name): ActionResultResponse;

    public function lockForm(ApplicationProgress $progress, string $form_name): ActionResultResponse;

    public function validate(mixed $input_data): Validator;
}
