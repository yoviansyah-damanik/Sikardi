<?php

namespace App\Repository;

use App\Enums\CssStatus;
use App\Models\Student;
use App\Enums\DayChoice;
use Illuminate\Support\Str;
use App\Helpers\GeneralHelper;

interface StudentInterface
{
    public static function getStudent(Student | string $student): array;
    public static function getAll(
        array $searchColumns,
        int $limit,
        ?string $search,
        string $studentStatus,
        ?int $semester,
        string $searchType,
        string | array | null $lecturerId,
        string $activationType,
        string $passType,
    ): \Illuminate\Pagination\LengthAwarePaginator | array;
    public static function getSupervisor(Student $student): array;
}

class StudentRepository implements StudentInterface
{
    const LIMIT_DEFAULT = 10;
    const WITH = [
        'user',
        'supervisor',
        'css',
        'css.responsibleLecturer',
        'css.details',
        'css.details.lecture',
        'css.details.lecturer',
        'css.details.course',
        'css.details.room'
    ];

    public static function getStudent(Student | String  $student): array
    {
        if (gettype($student) == 'string') {
            $student = Student::find($student);
        }

        return (new self)->mapping($student);
    }

    /**
     * @param string $searchColumns array - default ['name] | available columns: id, name
     * @param string $studentStatus 'all' | 'passed' | 'progress'
     * @param string $guidanceGroup | Guidance Group: 'all' OR id of Guidance Group
     */
    public static function getAll(
        array $searchColumns = ['name'],
        int $limit = self::LIMIT_DEFAULT,
        ?string $search = null,
        string $studentStatus = 'all',
        ?int $semester = null,
        string $searchType = 'all',
        string | array | null $lecturerId = null,
        string $activationType = 'all',
        string $passType = 'all',
        string | array | null $lectureId = null
    ): \Illuminate\Pagination\LengthAwarePaginator | array {
        $result = Student::with(self::WITH)
            ->whereAny($searchColumns, 'like', "$search%");

        if ($searchType != 'all') {
            if ($searchType == 'guidance_student') {
                $result = $result->whereHas('supervisor', function ($q) {
                    $q->where('lecturer_id', auth()->user()->data->id);
                });
            }

            if ($searchType == 'student_submission') {
                $result = $result->whereHas('supervisor', function ($q) {
                    $q->where('lecturer_id', auth()->user()->data->id);
                })->whereHas('css', function ($q) {
                    $q->where('year', \Carbon\Carbon::now())
                        ->where('type', GeneralHelper::currentSemester());
                });
            }

            if ($searchType == 'students') {
                $result = $result->whereHas('supervisor', function ($q) use ($lecturerId) {
                    $q->where('lecturer_id', $lecturerId);
                });
            }

            if ($searchType == 'lecture_students') {
                $result = $result->whereHas('lectures', function ($q) use ($lectureId) {
                    $q->where('lecture_id', $lectureId);
                });
            }
        }

        if ($activationType != 'all') {
            if ($activationType == 'suspended') {
                $result = $result->whereHas('user', function ($q) {
                    $q->where('is_suspended', true);
                });
            }

            if ($activationType == 'active') {
                $result = $result->whereHas('user', function ($q) {
                    $q->where('is_suspended', false);
                });
            }
        }
        if ($passType != 'all') {
            if ($passType == 'passed') {
                $result = $result->whereHas('passed');
            }

            if ($passType == 'not_yet_passed') {
                $result = $result->whereDoesntHave('passed');
            }
        }

        $result = $result->orderBy('stamp', 'desc')
            ->orderBy('name', 'asc')
            ->paginate($limit);

        return tap($result, function ($paginatedInstance) {
            return $paginatedInstance->getCollection()->transform(function ($value) {
                return (new self)
                    ->mapping($value);
            });
        });
    }

    private function mapping(Student $student): array
    {
        $isPassed = $student?->passed;

        $rand = rand(0, 2);
        return [
            'data' => [
                'npm' => $student->id,
                'name' => $student->name,
                'place_of_birth' => $student->place_of_birth,
                'date_of_birth' => $student->date_of_birth,
                'address' => $student->address,
                'gender' => $student->genderFull,
                'semester' => GeneralHelper::semester($student->stamp),
                'stamp' => $student->stamp,
                'phone_number' => $student->phone_number,
            ],
            'user' => $student->user->only(['id', 'email', 'last_login_at', 'is_suspended']),
            'supervisor' => static::getSupervisor($student),
            'submission' => static::getSubmission($student),
            'is_passed' => [
                'status' => $isPassed ? true : false,
                'message' => $isPassed ? __('Passed') : __('Not Yet Passed'),
                'data' => $isPassed ? $isPassed->only('gpa', 'semester', 'year') : null
            ],
            'course_selection_sheets' => static::getCss($student),
            'status' => isset($student->cssNow) ? $student->cssNow->status : 'not_yet',
        ];
    }

    public static function getSupervisor(Student $student): array
    {
        return $student?->supervisor ? [
            'nidn' => $student->supervisor->id,
            'name' => $student->supervisor->name,
            'gender' => $student->supervisor->genderFull,
            'phone_number' => $student->supervisor->phone_number
        ] : [];
    }

    public static function getSubmission(Student $student): array
    {
        return $student?->css->where('semester', $student->semester)->where('year', \Carbon\Carbon::now()->year)->count()
            ? (new static)->cssMapping($student->css->where('semester', $student->semester)->where('year', \Carbon\Carbon::now()->year)->first())
            :
            [];
    }

    public function getCss(Student $student)
    {
        $result = [];
        foreach (range(1, $student->semester) as $semester) {
            $result[] = [
                'semester' => $semester,
                'data' => $student?->css->where('semester', $semester)->where('status', CssStatus::approved->name)->first()
                    ? (new static)->cssMapping($student->css->where('semester', $semester)->where('status', CssStatus::approved->name)->first())
                    :
                    []
            ];
        }

        return $result;
    }

    private function cssMapping(Object $css)
    {
        return [
            ...$css->only('id', 'type', 'semester', 'year', 'status', 'message', 'max_load'),
            'cc_total' => $css->details->sum(function ($detail) {
                return $detail->lecture->course->credit;
            }),
            'lectures' => [
                ...$css->details->map(function ($detail) {
                    return $detail->lecture;
                })
            ],
            'responsible_lecturer' => $css->responsibleLecturer ? [
                'nidn' => $css->responsibleLecturer->id,
                'name' => $css->responsibleLecturer->name
            ] : [],
            'details' => [
                ...$css->details->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'limit' => $detail->limit,
                        'day_code' => $detail->day,
                        'day' => __(DayChoice::getName($detail->day)->value),
                        'type' => $detail->type,
                        'start_time' => Str::substr($detail->start_time, 0, 5),
                        'end_time' => Str::substr($detail->end_time, 0, 5),
                        'course_id' => $detail->course->id,
                        'course_code' => $detail->course->code,
                        'course' => $detail->course->name,
                        'semester' => $detail->course->semester,
                        'room_id' => $detail->room->id,
                        'room_code' => $detail->room->code,
                        'room' => $detail->room->name,
                        'lecturer_id' => $detail->lecturer->id,
                        'lecturer' => $detail->lecturer->name,
                        'cc' => $detail->course->credit,
                        'lecture_ref' => $detail->lecture->only(
                            'id',
                            'course_id',
                            'room_id',
                            'lecturer_id',
                            'limit',
                            'day',
                            'start_time',
                            'end_time',
                        )
                    ];
                })
                    ->sortBy(function ($item) {
                        return array_flip(collect(DayChoice::values())->map(fn ($item) => __($item))->toArray())[$item['day']];
                    })
            ],
            'date' => $css->created_at
        ];
    }
}
