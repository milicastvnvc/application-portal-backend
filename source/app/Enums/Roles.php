<?php

namespace App\Enums;

enum Roles: string
{
    case Admin = 'admin';
    case Applicant = 'applicant';
    case Coordinator = 'coordinator';
}
