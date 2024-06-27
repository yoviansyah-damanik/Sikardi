<?php

namespace App\Livewire\Staff\Lecture;

use App\Models\Lecture;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Repository\StudentRepository;

class ShowStudent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $listeners = ['setShowLectureStudents', 'clearModal'];

    public ?Lecture $lecture = null;
    public bool $isLoading = true;
    public string $search = '';

    public function render()
    {
        $students = StudentRepository::getAll(limit: 10, search: $this->search, searchColumns: ['id', 'name'], searchType: 'lecture_students', lectureId: $this?->lecture?->id);
        return view('pages.staff.lecture.show-student', compact('students'));
    }

    public function setShowLectureStudents(Lecture $lecture)
    {
        $this->isLoading = true;
        $this->lecture = $lecture;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }
}
