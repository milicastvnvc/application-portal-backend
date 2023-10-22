<?php

namespace App\Repositories\Interfaces;

interface IDocumentTypeRepository extends IBaseRepository
{
    public function getByMobilityType($mobility_type);

    public function countDocumentsByMobilityType($mobility_type);
}
