<?php

namespace App\Enums;

enum MobilityType: int
{
    case Student = 0;
    case Traineeship = 1;
    case Staff = 2;
    case Other = 3;
}
