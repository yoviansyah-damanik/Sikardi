<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Courses extends Component
{
    use WithPagination;

    protected $listeners = ['refreshCourse' => '$refresh'];

    #[Url]
    public ?string $search = null;

    public array $semesters;

    #[Url]
    public int | string $semester;

    public $activeCurriculum;

    public $curricula;

    public function mount()
    {
        $this->curricula = Curriculum::get();

        $this->activeCurriculum = $this->curricula->where('is_active', true)
            ->first()->id;
    }

    public function render()
    {
        $courses = Course::with('curriculum')
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->where('curriculum_id', $this->activeCurriculum);

        $courses = $courses
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->orderBy('semester', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.courses', compact('courses'))
            ->title(__('Courses'));
    }
}
