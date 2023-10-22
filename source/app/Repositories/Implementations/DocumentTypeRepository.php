<?php

namespace App\Repositories\Implementations;

use App\Models\DocumentType;
use App\Repositories\Interfaces\IDocumentTypeRepository;

class DocumentTypeRepository extends BaseRepository implements IDocumentTypeRepository
{
    protected $model;

    public function __construct(DocumentType $model)
    {
        $this->model = $model;
    }

    public function getByMobilityType($mobility_type)
    {
        return $this->model
        ::whereHas('mobility_types', function ($query) use($mobility_type) {
            return $query->where('mobility_type', '=', $mobility_type);
        })
        ->with(['mobility_types', 'links'])
        ->get();
    }

    public function countDocumentsByMobilityType($mobility_type) {

        return $this->model
        ::whereHas('mobility_types', function ($query) use($mobility_type) {
            return $query->where('mobility_type', '=', $mobility_type);
        })
        ->where('is_required', true)
        ->count();
    }
}
