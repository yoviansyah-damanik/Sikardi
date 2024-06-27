<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum CssStatus
{
    use EnumTrait;

    case revision;
    case approved;
    case waiting;
}
