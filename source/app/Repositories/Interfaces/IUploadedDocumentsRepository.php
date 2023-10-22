<?php

namespace App\Repositories\Interfaces;

interface IUploadedDocumentsRepository extends IFormRepository
{
    public function getDocumentsByApplication($application_id);

    public function countDocumentsByApplication($applicaiton_id);
}
