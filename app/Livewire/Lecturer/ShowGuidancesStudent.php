<?php

namespace App\Livewire\Lecturer;

use Livewire\Component;
use App\Models\Lecturer;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Repository\StudentRepository;
use Livewire\Attributes\Url;

class ShowGuidancesStudent extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $listeners = ['setGuidancesStudent', 'clearModal'];
    public $lecturer;
    public bool $isLoading = true;

    #[Url]
    public string $search = '';

    public function render()
    {
        $students = StudentRepository::getAll(limit: 10, search: $this->search, searchColumns: ['id', 'name'], searchType: 'students', lecturerId: $this->lecturer?->id);
        return view('pages.lecturer.show-guidances-student', compact('students'));
    }

    public function setGuidancesStudent(Lecturer $lecturer)
    {
        $this->isLoading = true;
        $this->reset();
        $this->lecturer = $lecturer;
        $this->isLoading = false;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }
}
