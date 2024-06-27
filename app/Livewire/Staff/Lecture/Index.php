<?php

namespace App\Livewire\Staff\Lecture;

use App\Models\Room;
use App\Models\Lecture;
use Livewire\Component;
use App\Enums\DayChoice;
use App\Models\Curriculum;
use App\Models\Lecturer;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshLecture' => '$refresh'];

    public array $rooms;
    public array $courses;
    public array $days;
    public array $semesters;
    public array $lecturers;

    public ?Curriculum $activeCurriculum = null;

    #[Url]
    public int | string $room;
    #[Url]
    public int | string $course;
    #[Url]
    public int | string $day;
    #[Url]
    public int | string $semester;
    #[Url]
    public int | string $lecturer;

    public function mount()
    {
        $this->rooms = Room::get()
            ->map(fn ($room) => [
                'value' => $room->id,
                'title' => "($room->code) " . $room->name,
            ])
            ->toArray();

        $this->room = 'all';

        if (!$this->rooms) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('No room found. Please add the room first.'));

            return to_route('staff.room');
        }

        $this->activeCurriculum = Curriculum::where('is_active', true)
            ->first();

        if (!$this->activeCurriculum) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('There is no active curriculum. Please activate the curriculum first.'));

            return to_route('staff.curriculum');
        }

        $this->courses = $this->activeCurriculum
            ->courses()
            ->get()
            ->map(function ($course) {
                return [
                    'value' => $course->id,
                    'title' => "($course->code) " . $course->name,
                ];
            })->toArray();

        $this->course = 'all';

        if (!$this->courses) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('No course found. Please add the course first.'));

            return to_route('staff.course');
        }

        $this->days = collect(DayChoice::array())
            ->map(fn ($day, $key) => [
                'title' => __($day),
                'value' => $key
            ])
            ->values()
            ->toArray();

        $this->day = 'all';

        $this->semesters = collect(range(1, 8))
            ->map(fn ($semester) => [
                'title' => __('Semester :1', ['1' => $semester]),
                'value' => $semester
            ])->toArray();

        $this->semester = 'all';

        $this->lecturers = Lecturer::get()
            ->map(fn ($lecturer) => [
                'value' => $lecturer->id,
                'title' => "($lecturer->id) " . $lecturer->name,
            ])
            ->toArray();
        $this->lecturer = 'all';
    }

    public function render()
    {
        $lectures = Lecture::with('room', 'course', 'lecturer', 'css', 'css.css')
            ->whereHas('course', fn ($q) => $q->where('curriculum_id', $this->activeCurriculum->id));

        if ($this->room != 'all') {
            $lectures = $lectures->where('room_id', $this->room);
        }

        if ($this->course != 'all') {
            $lectures = $lectures->where('course_id', $this->course);
        }

        if ($this->lecturer != 'all') {
            $lectures = $lectures->where('lecturer_id', $this->lecturer);
        }

        if ($this->day != 'all') {
            $lectures = $lectures->where('day', $this->day);
        }

        if ($this->semester != 'all') {
            $lectures = $lectures->whereHas('course', fn ($q) => $q->where('semester', $this->semester));
        }

        $lectures = $lectures->orderBy('day', 'asc')
            ->paginate(15);

        return view('pages.staff.lecture.index', compact('lectures'))
            ->title(__('Lecture'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
