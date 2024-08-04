<?php

namespace App\Repositories\Interfaces;

use App\Enums\MobilityType;
use Illuminate\Database\Eloquent\Collection;

interface IDocumentTypeRepository extends IBaseRepository
{
    public function getByMobilityType(MobilityType $mobility_type): Collection;

    public function countDocumentsByMobilityType(MobilityType $mobility_type): int;
}
