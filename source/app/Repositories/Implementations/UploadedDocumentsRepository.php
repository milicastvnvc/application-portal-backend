<?php

namespace App\Repositories\Implementations;

use App\Models\UploadedDocument;
use App\Repositories\Interfaces\IUploadedDocumentsRepository;

class UploadedDocumentsRepository extends FormRepository implements IUploadedDocumentsRepository
{
    protected $model;

    public function __construct(UploadedDocument $model)
    {
        $this->model = $model;
    }

    public function getDocumentsByApplication($application_id)
    {
        return $this->model
        ->where('application_id', $application_id)
        ->get();
    }

    public function countDocumentsByApplication($application_id)
    {
        return $this->model
        ->where('application_id', $application_id)
        ->count();
    }
}
