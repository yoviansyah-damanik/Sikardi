<?php

namespace App\Livewire\Staff\Course;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ShowData extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $listeners = ['setShowCourses', 'clearModal'];

    public ?Curriculum $curriculum = null;

    public bool $isLoading = true;
    public string $search = '';

    public function render()
    {
        $courses = $this->setCourses();
        return view('pages.staff.course.show-data', compact('courses'));
    }

    public function setCourses()
    {
        return $this->curriculum
            ?->courses()
            ->whereAny(['code', 'name'], 'like', $this->search . "%")
            ->orderBy('semester', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function setShowCourses(Curriculum $curriculum)
    {
        $this->isLoading = true;
        $this->curriculum = $curriculum;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function updated()
    {
        $this->resetPage();
    }
}
