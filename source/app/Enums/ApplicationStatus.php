<?php

namespace App\Enums;

enum ApplicationStatus: int
{
    case Created = 0;
    case Pending = 1;
    case Completed = 2;
    case Rejected = 3;
    case AdditionalDocuments = 4;
}
