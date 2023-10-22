<?php

namespace App\ViewModels;

use App\Models\ApplicationProgress;

class ApplicationProgressViewModel
{
    public $application_id;
    public $personal_details;
    public $home_institution;
    public $proposed_host_universities;
    public $motivation_and_added_value;
    public $documents_upload;

    public function __construct(ApplicationProgress $progress)
    {
        $this->application_id = $progress->application_id;
        $this->personal_details =  $progress->personal_details;
        $this->home_institution = $progress->home_institution;
        $this->proposed_host_universities = $progress->proposed_host_universities;
        $this->motivation_and_added_value = $progress->motivation_and_added_value;
        $this->documents_upload = $progress->documents_upload;
    }
}
