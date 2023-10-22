<?php

namespace App\Repositories\Interfaces;

interface IUnlockedFormRepository extends IBaseRepository
{
    public function findByApplicationIdAndFormName($applicayion_id, $form_name);

    public function countByApplicationId($application_id);
}
