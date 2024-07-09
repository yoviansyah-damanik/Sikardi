<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Configuration;
use Illuminate\Support\Facades\Schema;

class GeneralHelper
{
    private static $configs;

    public function __construct()
    {
        if (Schema::hasTable('configurations'))
            static::$configs = Configuration::get();
    }

    private static function get($config)
    {
        return collect(static::$configs)
            ->where('attribute', $config)
            ->first()
            ->value;
    }

    public static function appName()
    {
        return static::get('app_name');
    }

    public static function appFullname()
    {
        return static::get('app_fullname');
    }

    public static function isOpen()
    {
        return static::get('is_open');
    }

    public static function oddSemester()
    {
        return static::get('odd_semester');
    }

    public static function evenSemester()
    {
        return static::get('even_semester');
    }

    public static function startDate()
    {
        return static::get('start_date');
    }

    public static function endDate()
    {
        return static::get('end_date');
    }

    public static function ccLimit()
    {
        return static::get('cc_limit');
    }

    public static function nameOfDepartmentHead()
    {
        return static::get('name_of_department_head');
    }

    public static function nidnOfDepartmentHead()
    {
        return static::get('nidn_of_department_head');
    }

    public static function currentSemester()
    {
        $now = Carbon::now();
        $start = Carbon::createFromFormat('d-m', static::get('odd_semester'))->startOfDay();
        $end = Carbon::createFromFormat('d-m', static::get('even_semester'))->addDays(-1)->endOfDay();

        if ($now->isAfter($end)) return 'even';
        if ($now->isBetween($start, $end)) return 'odd';
        return 'unknown';
    }

    public static function semester(int $stamp)
    {
        $semester = (Carbon::now()->year - $stamp) * 2;

        if (static::currentSemester() == 'even') return $semester;
        if (static::currentSemester() == 'odd') return $semester + 1;
    }

    public static function dateFormat(?string $date, string $type = 'default')
    {
        switch ($type) {
            case 'short':
                $format = Carbon::parse($date)->translatedFormat('d/m/Y');
                break;
            case 'simple':
                $format = Carbon::parse($date)->translatedFormat('d F Y');
                break;
            default:
                $format = Carbon::parse($date)->translatedFormat('d F Y H:i:s');
                break;
        }

        return $format;
    }

    public static function isFillingOpen()
    {
        $startDate = Carbon::parse(static::startDate());
        $endDate = Carbon::parse(static::endDate());
        $now = Carbon::now();

        if ($now->isBetween($startDate, $endDate))
            return true;

        return false;
    }
}
