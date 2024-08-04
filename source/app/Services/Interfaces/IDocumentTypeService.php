<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;
use Illuminate\Http\Request;

interface IDocumentTypeService
{
    public function getByMobilityType(Request $request): ActionResultResponse;
}
