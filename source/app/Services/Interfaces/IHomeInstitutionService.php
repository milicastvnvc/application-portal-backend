<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;


interface IHomeInstitutionService
{
    public function getById(Request $request): ActionResultResponse;

    public function getAll(): ActionResultResponse;

    public function create(Request $create_request): ActionResultResponse;
}
