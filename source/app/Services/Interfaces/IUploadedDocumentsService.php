<?php

namespace App\Services\Interfaces;

interface IUploadedDocumentsService
{
    public function getByApplicationId($application_id, $user_id);

    public function createOrUpdate($request);

    public function download($request);
}
