<?php

namespace App\Repository;

use App\Enums\CssStatus;
use App\Models\Lecture;
use App\Enums\DayChoice;
use App\Models\Lecturer;
use Illuminate\Support\Str;

class LecturerRepository
{
    public static function getSchedule(Lecturer $lecturer)
    {
        return (new static)->mapping($lecturer);
    }

    public static function getTodaysSchedule(Lecturer $lecturer)
    {
        $data = (new static)->mapping($lecturer);

        return $data->where('day', \Carbon\Carbon::now()->dayName);
    }

    private function mapping(Lecturer $lecturer)
    {
        $schedules = Lecture::with('room', 'course', 'lecturer', 'css', 'css.css', 'cssThrough')
            ->where('lecturer_id', $lecturer->id)
            ->get()
            ->map(function ($item) {
                return [
                    'lecture_id' => $item->id,
                    'limit' => $item->limit,
                    'day_code' => $item->day,
                    'day' => __(DayChoice::getName($item->day)->value),
                    'start_time' => Str::substr($item->start_time, 0, 5),
                    'end_time' => Str::substr($item->end_time, 0, 5),
                    'course_code' => $item->course->code,
                    'course' => $item->course->name,
                    'semester' => $item->course->semester,
                    'room_code' => $item->room->code,
                    'room' => $item->room->name,
                    'lecturer_id' => $item->lecturer->id,
                    'lecturer' => $item->lecturer->name,
                    'cc' => $item->course->credit,
                    'student_total' =>  $item->css->count() ? $item->css->filter(function ($css_) {
                        return $css_->css->status == CssStatus::approved->name && $css_->css->year == \Carbon\Carbon::now()->year;
                    })->count() : 0
                ];
            })
            ->sortBy(function ($item) {
                return array_flip(collect(DayChoice::values())->map(fn ($item) => __($item))->toArray())[$item['day']];
            });

        return $schedules;
    }
}
