<?php

namespace App\Helpers;

use App\Models\Application;

class ApplicationHelper
{

    public static function checkCanYouModify(Application $application, string $form_name)
    {

        if ($application->submitted_at) return false; //ne sme ako je vec submitovana iliti sve su zakljucane

        $unlocked_array = $application->unlocked_forms->toArray();

        $filtered = array_filter($unlocked_array, function ($obj) use ($form_name) {
            return $obj['form_name'] === $form_name;
        });

        if (!empty($filtered) || !count($unlocked_array)) //sme ako je otkljucana ili ukoliko nema otkljucanih iliti jos se popunjava
            return true;

        return false;
    }
}
