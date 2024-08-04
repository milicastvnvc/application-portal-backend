<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface IUploadedDocumentsRepository extends IFormRepository
{
    public function getDocumentsByApplication(int $application_id, array $relations = []): Collection;

    public function countDocumentsByApplication(int $applicaiton_id): int;
}
