<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum UserType
{
    use EnumTrait;

    case lecturer;
    case headOfUndergraduate;
    case staff;
    case student;
}
