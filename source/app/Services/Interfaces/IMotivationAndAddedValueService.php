<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

interface IMotivationAndAddedValueService
{
    public function getByApplicationId(int $application_id, mixed $user): ActionResultResponse;

    public function createOrUpdate(Request $request): ActionResultResponse;

    public function validate(mixed $input_data): Validator;
}
