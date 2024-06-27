<?php

namespace App\Livewire\Staff\Lecture;

use App\Enums\CssStatus;
use App\Models\CourseSelectionSheetDetail;
use App\Models\Lecture;
use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEditLecture', 'clearModal'];

    public bool $isLoading = false;

    public array $rooms;
    public string $room;

    public array $availableCourses;
    public array $courses;
    public ?string $course;

    public array $days;
    public string $day;

    public array $curricula;
    public string $curriculum;

    public string $start_time;
    public string $end_time;

    public int $limit;

    public array $lecturers;
    public string $lecturer;

    public ?Curriculum $activeCurriculum = null;
    public ?Lecture $lecture = null;

    public function mount(array $rooms, array $days, array $lecturers, array $courses, $activeCurriculum)
    {
        $this->activeCurriculum = $activeCurriculum;

        $this->courses = $courses;
        $this->lecturers = $lecturers;
        $this->rooms = $rooms;
        $this->days = $days;
    }

    public function render()
    {
        return view('pages.staff.lecture.edit');
    }

    public function rules()
    {
        return [
            'room' => [
                'required',
                Rule::in(collect($this->rooms)->pluck('value'))
            ],
            'course' => [
                'required',
                Rule::in(collect($this->courses)->pluck('value'))
            ],
            'day' => [
                'required',
                Rule::in(collect($this->days)->pluck('value'))
            ],
            'lecturer' => [
                'required',
                Rule::in(collect($this->lecturers)->pluck('value'))
            ],
            'limit' => 'required|numeric|min:1',
            'start_time' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
            'end_time' => ['required', 'regex:/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'room' => __('Room'),
            'course' => __('Course'),
            'day' => __('Day'),
            'start_time' => __('Start Time'),
            'end_time' => __('End Time'),
            'limit' => __('Limit'),
            'lecturer' => __('Lecturer')
        ];
    }

    public function setEditLecture(Lecture $lecture)
    {
        $this->isLoading = true;

        $this->lecture = $lecture;
        $this->room = $lecture->room_id;
        $this->curriculum = $lecture->curriculum->id;
        $this->course = $lecture->course_id;
        $this->day = $lecture->day;
        $this->lecturer = $lecture->lecturer_id;
        $this->limit = $lecture->limit;
        $this->start_time = Str::substr($lecture->start_time, 0, 5);
        $this->end_time = Str::substr($lecture->end_time, 0, 5);

        $this->isLoading = false;
    }

    public function refresh()
    {
        $this->reset(
            'room',
            'course',
            'day',
            'curriculum',
            'start_time',
            'end_time',
            'limit'
        );

        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->refresh();
        $this->isLoading = true;
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            if ($this->lecture->choosen > 0) {
                $this->alert('warning', __('Cannot change Lecture because there are students who have already taken that Lecture.'));
                return;
            }

            $this->lecture->update([
                'room_id' => $this->room,
                'course_id' => $this->course,
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'limit' => $this->limit,
            ]);

            CourseSelectionSheetDetail::where('lecturer_id', $this->lecture->id)
                ->whereHas('css', fn ($q) => $q->where('status', '!=', CssStatus::approved->name))
                ->update([
                    'room_id' => $this->room,
                    'course_id' => $this->course,
                    'day' => $this->day,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'limit' => $this->limit,
                ]);

            DB::commit();
            $this->dispatch('refreshLecture');
            $this->dispatch('toggle-edit-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Lecture')])]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
