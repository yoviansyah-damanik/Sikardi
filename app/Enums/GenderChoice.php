<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum GenderChoice: string
{
    use EnumTrait;

    case L = 'Laki-laki';
    case P = 'Perempuan';
}
