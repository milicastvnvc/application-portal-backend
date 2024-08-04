<?php

namespace App\Enums;

enum FormProgress: int
{
    case Incompleted = 0;
    case Completed = 1;
    case Unlocked = 2;
}
