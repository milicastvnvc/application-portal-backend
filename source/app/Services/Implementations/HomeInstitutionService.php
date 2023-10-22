<?php

namespace App\Services\Implementations;

use App\ViewModels\ActionResultResponse;
use App\Repositories\Interfaces\IHomeInstitutionRepository;
use App\Services\Interfaces\IHomeInstitutionService;

class HomeInstitutionService implements IHomeInstitutionService
{
    private $homeInstitutionRepository;

    public function __construct(IHomeInstitutionRepository $homeInstitutionRepository)
    {
        $this->homeInstitutionRepository = $homeInstitutionRepository;
    }

    public function getById($request)
    {
        $response = new ActionResultResponse();

        $homeInstitution = $this->homeInstitutionRepository->findById($request->id, columns:['id', 'name']);

        if(!$homeInstitution) {
            $response->setErrors(['Home Institution does not exist']);
            return $response;
        }

        $response->setSuccess($homeInstitution);

        return $response;

    }

    public function getAll()
    {
        $response = new ActionResultResponse();

        $homeInstitutions = $this->homeInstitutionRepository->all(columns:['id', 'name']);

        $response->setSuccess($homeInstitutions);

        return $response;
    }

    public function create($create_request)
    {
        $response = new ActionResultResponse();

        $home_institution = $this->homeInstitutionRepository->create([
            "name" => $create_request->name
        ]);

        if(!$home_institution){
            $response->setErrors(['Error while creating home instution']);
            return $response;
        }

        $response->setSuccess(null);

        return $response;
    }
}
