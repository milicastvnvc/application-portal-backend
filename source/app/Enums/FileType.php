<?php

namespace App\Enums;

enum FileType: int
{
    case Document = 0;
    case Image = 1;
    case Video = 2;
    case Other = 3;
}
