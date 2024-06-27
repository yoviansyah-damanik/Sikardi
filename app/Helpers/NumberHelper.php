<?php

namespace App\Helpers;

class NumberHelper
{
    public static function format(
        $number,
        string $type = 'number',
        string $lang = 'id',
        int $decimals = 0,
    ) {
        $options = new static();
        $options = $options->options($lang);

        $result[] = number_format($number, $decimals, $options['decimal_separator'], $options['thousands_separator']);

        if ($type == 'number') {
        } elseif ($type == 'currency') {
            if ($options['currencyPosition'] == 'left')
                array_unshift($result, $options['currencySymbol']);
            else
                $result[] = $options['currencySymbol'];
        }

        return implode(' ', $result);
    }

    protected function options(string $lang)
    {
        $separatorFormats = [
            'id' => [
                'decimal_separator' => ',',
                'thousands_separator' => '.',
                'currencyPosition' => 'left',
                'currency' => 'Rupiah',
                'currencySymbol' => 'Rp'
            ],
            'en' => [
                'decimal_separator' => ',',
                'thousands_separator' => '.',
                'currencyPosition' => 'left',
                'currency' => 'USD',
                'currencySymbol' => '$'
            ]
        ];
        return $separatorFormats[$lang];
    }
}
