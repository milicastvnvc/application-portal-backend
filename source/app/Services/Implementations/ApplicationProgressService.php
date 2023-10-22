<?php

namespace App\Services\Implementations;

use App\ViewModels\ActionResultResponse;
use App\Repositories\Interfaces\IApplicationProgressRepository;
use App\Services\Interfaces\IApplicationProgressService;

class ApplicationProgressService implements IApplicationProgressService
{
    private $applicationProgressRepository;

    public function __construct(IApplicationProgressRepository $applicationProgressRepository)
    {
        $this->applicationProgressRepository = $applicationProgressRepository;
    }

    public function getByApplicationId($application_id)
    {
        $response = new ActionResultResponse();

        $progress = $this->applicationProgressRepository->findByApplicationId($application_id);

        if(!$progress) {
            $response->setErrors(['Application progress with this id does not exist']);
            return $response;
        }

        $response->setSuccess($progress);

        return $response;

    }
}
