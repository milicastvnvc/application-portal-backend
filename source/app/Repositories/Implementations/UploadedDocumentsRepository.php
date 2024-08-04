<?php

namespace App\Repositories\Implementations;

use App\Models\UploadedDocument;
use App\Repositories\Interfaces\IUploadedDocumentsRepository;
use Illuminate\Database\Eloquent\Collection;

class UploadedDocumentsRepository extends FormRepository implements IUploadedDocumentsRepository
{
    protected $model;

    public function __construct(UploadedDocument $model)
    {
        $this->model = $model;
    }

    public function getDocumentsByApplication(int $application_id, array $relations = []): Collection
    {
        return $this->model
        ->where('application_id', $application_id)
        ->with($relations)
        ->get();
    }

    public function countDocumentsByApplication(int $application_id): int
    {
        return $this->model
        ->where('application_id', $application_id)
        ->count();
    }
}
