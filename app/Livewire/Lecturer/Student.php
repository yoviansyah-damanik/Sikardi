<?php

namespace App\Livewire\Lecturer;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Repository\StudentRepository;

class Student extends Component
{
    use WithPagination;
    #[Url]
    public string $search = '';
    public int $limit = 15;

    public function render()
    {
        $students = StudentRepository::getAll(limit: $this->limit, search: $this->search, searchColumns: ['name', 'id'],  searchType: 'guidance_student');

        return view('pages.lecturer.student', compact('students'))
            ->title(__("Guidance's Student"));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
