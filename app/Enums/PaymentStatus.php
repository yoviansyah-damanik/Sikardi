<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum PaymentStatus
{
    use EnumTrait;
    case paid;
    case waiting;
    case rejected;
}
