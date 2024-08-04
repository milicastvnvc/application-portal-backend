<?php

namespace App\Services\Implementations;

use App\Repositories\Interfaces\IMobilityRepository;
use App\Services\Interfaces\IMobilityService;
use App\ViewModels\ActionResultResponse;

class MobilityService implements IMobilityService
{
    private $mobilityRepository;

    public function __construct(IMobilityRepository $mobilityRepository)
    {
        $this->mobilityRepository = $mobilityRepository;
    }

    public function getAll(): ActionResultResponse
    {
        $response = new ActionResultResponse();

        $mobilities = $this->mobilityRepository->all(columns:['id', 'name', 'description', 'type']);

        $response->setSuccess($mobilities);

        return $response;
    }
}
