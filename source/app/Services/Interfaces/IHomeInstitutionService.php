<?php

namespace App\Services\Interfaces;

interface IHomeInstitutionService
{
    public function getById($request);

    public function getAll();

    public function create($create_request);
}
