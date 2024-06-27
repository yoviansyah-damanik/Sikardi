<?php

namespace App\Livewire\Lecturer;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Repository\StudentRepository;

class StudentSubmission extends Component
{
    use WithPagination;
    #[Url]
    public string $search = '';
    public int $limit = 15;

    public function render()
    {
        $students = StudentRepository::getAll(limit: $this->limit, search: $this->search, searchColumns: ['name', 'id'], searchType: 'student_submission');

        return view('pages.lecturer.student-submission', compact('students'))
            ->title(__('Student Submission'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
