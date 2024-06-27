<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Repository\StudentRepository;

class CourseSelectionSheet extends Component
{
    public $student;
    public array $semesters;

    #[Url]
    public $semester;

    public function mount()
    {
        $this->student = StudentRepository::getStudent(auth()->user()->data->id);
        $this->semesters = collect(range(1, $this->student['data']['semester']))->map(
            fn ($semester) => [
                'title' => __(':semester Semester', ['semester' => $semester]),
                'value' => $semester
            ]
        )->toArray();

        $this->semester = request()->semester
            ? (
                request()->semester > $this->student['data']['semester']
                ? $this->student['data']['semester']
                : request()->semester
            ) : $this->student['data']['semester'];
    }

    public function render()
    {
        return view('pages.student.course-selection-sheet',)
            ->title(__('Course Selection Sheet (CSS)'));
    }
}
