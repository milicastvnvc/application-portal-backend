<?php

namespace App\Helpers;

use App\Enums\ApplicationStatus;
use App\Enums\FormProgress;
use App\Models\Application;

class ApplicationHelper
{

    public static function checkCanYouModify(Application $application, string $form_name)
    {
        if ($application->status != ApplicationStatus::Created && $application->status != ApplicationStatus::AdditionalDocuments)
            return false;

        if ($application->status == ApplicationStatus::AdditionalDocuments)
        {
            $progress = $application->application_progress;
            if ($progress[$form_name] == FormProgress::Unlocked) return true;
            else return false;
        }

        return true;
    }
}
