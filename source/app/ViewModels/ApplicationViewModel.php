<?php

namespace App\ViewModels;

use App\Models\Application;

class ApplicationViewModel
{
    public $id;
    public $user_id;
    public $user;
    public $home_institution_id;
    public $home_institution;
    public $mobility_id;
    public $mobility;
    public $status;
    public $submitted_at;
    public $progress;

    public function __construct(Application $application)
    {
        $this->id = $application->id;
        $this->user_id = $application->user_id;
        if ($application->user) $this->user = new UserViewModel($application->user);
        $this->mobility_id = $application->mobility_id;
        $this->mobility = $application->mobility;
        $this->home_institution_id = $application->home_institution_id;
        $this->home_institution = $application->home_institution;
        $this->status = $application->status;
        $this->submitted_at = $application->submitted_at;
        if ($application->application_progress)
            $this->progress = new ApplicationProgressViewModel($application->application_progress);
    }
}
