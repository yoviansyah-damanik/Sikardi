<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Repository\StudentRepository;

class ShowDataCss extends Component
{
    public $student;

    protected $listeners = ['setStudent', 'clearModal'];

    public array $semesters;
    public int $semester;

    public bool $isLoading = true;

    public function render()
    {
        return view('pages.student.show-data-css');
    }

    public function setStudent($student)
    {
        $this->isLoading = true;
        $this->reset('student', 'semester', 'semesters');
        $this->student = StudentRepository::getStudent($student);
        $this->semesters = collect(range(1, $this->student['data']['semester']))->map(
            fn ($semester) => [
                'title' => __(':semester Semester', ['semester' => $semester]),
                'value' => $semester
            ]
        )->toArray();
        $this->semester = $this->student['data']['semester'];
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset('student', 'semester', 'semesters');
        $this->isLoading = true;
    }
}
