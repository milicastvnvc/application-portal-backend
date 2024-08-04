<?php

namespace App\Enums;

enum MobilityType: int
{
    case Student = 0;
    case Traineeship = 1;
    case StaffAcademic = 2;
    case StaffNonAcademic = 3;
    case Other = 4;
}
