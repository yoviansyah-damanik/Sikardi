<?php

namespace App\Livewire\Staff\Lecture;

use App\Models\Room;
use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculum;
use App\Models\Lecture;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ShowData extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $listeners = ['setShowLectures', 'clearModal'];

    public ?Room $room = null;
    public ?Curriculum $curriculum = null;
    public ?Course $course = null;

    public bool $isLoading = true;
    public ?string $type = null;

    public function render()
    {
        $lectures = $this->setLectures();
        return view('pages.staff.lecture.show-data', compact('lectures'));
    }

    public function setLectures()
    {
        $lectures = new Lecture();

        if ($this->type == 'curriculum') {
            $lectures = $this->curriculum->lectures();
        }

        if ($this->type == 'room') {
            $lectures = $this->room->lectures();
        }

        if ($this->type == 'course') {
            $lectures = $this->course->lectures();
        }

        return $lectures
            ->orderBy('day', 'asc')
            ->paginate(10);
    }

    public function setShowLectures(string $type, ?Room $room = null, ?Curriculum $curriculum, ?Course $course = null)
    {
        $this->isLoading = true;
        $this->type = $type;
        $this->room = $room;
        $this->curriculum = $curriculum;
        $this->course = $course;
        $this->isLoading = false;
    }
}
