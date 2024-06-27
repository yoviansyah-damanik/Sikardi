<?php

namespace App\Traits;

trait EnumTrait
{
    public static function values(): array
    {
        $result = collect(self::cases())
            ->map(fn ($item) => $item->value)
            ->toArray();

        return $result;
    }

    public static function names(): array
    {
        $result = collect(self::cases())
            ->map(fn ($item) => $item->name)
            ->toArray();

        return $result;
    }

    public static function array(): array
    {
        $result = collect(self::cases())
            ->map(fn ($item) => [$item->name => $item->value])
            ->collapse()
            ->toArray();

        return $result;
    }

    public static function getName(string $name)
    {
        return constant("self::$name");
    }
}
