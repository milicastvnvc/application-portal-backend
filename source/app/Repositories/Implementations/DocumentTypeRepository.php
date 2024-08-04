<?php

namespace App\Repositories\Implementations;

use App\Enums\MobilityType;
use App\Models\DocumentType;
use App\Repositories\Interfaces\IDocumentTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class DocumentTypeRepository extends BaseRepository implements IDocumentTypeRepository
{
    protected $model;

    public function __construct(DocumentType $model)
    {
        $this->model = $model;
    }

    public function getByMobilityType(MobilityType $mobility_type): Collection
    {
        return $this->model
        ::whereHas('mobility_types', function ($query) use($mobility_type) {
            return $query->where('mobility_type', '=', $mobility_type);
        })
        ->with(['links'])
        ->get();
    }

    public function countDocumentsByMobilityType(MobilityType $mobility_type): int {

        return $this->model
        ::whereHas('mobility_types', function ($query) use($mobility_type) {
            return $query->where('mobility_type', '=', $mobility_type);
        })
        ->where('is_required', true)
        ->count();
    }
}
