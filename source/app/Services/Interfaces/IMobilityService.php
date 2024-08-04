<?php

namespace App\Services\Interfaces;

use App\ViewModels\ActionResultResponse;

interface IMobilityService
{
    public function getAll(): ActionResultResponse;
}
