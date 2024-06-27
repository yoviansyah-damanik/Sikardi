<?php

namespace App\Livewire\Staff\Lecture;

use App\Models\Room;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Lecture;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['clearModal'];

    public bool $isLoading = false;

    public array $rooms;
    public string $room;

    public array $courses;
    public string $course;

    public array $days;
    public string $day;

    public string $start_time;
    public string $end_time;

    public array $lecturers;
    public string $lecturer;

    public int $limit;

    public ?Curriculum $activeCurriculum = null;

    public function mount(array $rooms, array $days, array $lecturers, array $courses, $activeCurriculum)
    {
        $this->activeCurriculum = $activeCurriculum;

        $this->courses = $courses;
        $this->course = $courses[0]['value'];

        $this->lecturers = $lecturers;
        $this->lecturer = $lecturers[0]['value'];

        $this->rooms = $rooms;
        $this->room = $rooms[0]['value'];

        $this->days = $days;
        $this->day = $days[0]['value'];
    }

    public function render()
    {
        return view('pages.staff.lecture.create');
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
            'lecturer' => __('Lecturer'),
            'start_time' => __('Start Time'),
            'end_time' => __('End Time'),
            'limit' => __('Limit'),
        ];
    }

    public function refresh()
    {
        $this->reset('room', 'lecturer', 'course',  'day', 'start_time', 'end_time', 'limit');
        $this->room = $this->rooms[0]['value'];
        $this->day = $this->days[0]['value'];
        $this->lecturer = $this->lecturers[0]['value'];
        $this->course = $this->courses[0]['value'];
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            Lecture::create([
                'room_id' => $this->room,
                'course_id' => $this->course,
                'lecturer_id' => $this->lecturer,
                'day' => $this->day,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'limit' => $this->limit,
            ]);

            DB::commit();
            $this->refresh();
            $this->dispatch('refreshLecture');
            $this->dispatch('toggle-create-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Lecture')])]);
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
