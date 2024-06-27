<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum DayChoice: string
{
    use EnumTrait;

    case MON = 'Monday';
    case TUE = 'Tuesday';
    case THU = 'Thursday';
    case WED = 'Wednesday';
    case FRI = 'Friday';
    case SAT = 'Saturday';
}
