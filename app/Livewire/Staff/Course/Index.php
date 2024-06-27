<?php

namespace App\Livewire\Staff\Course;

use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshCourse' => '$refresh'];

    #[Url]
    public ?string $search = null;

    public array $semesters;

    #[Url]
    public int | string $semester;

    public ?Curriculum $activeCurriculum = null;

    public function mount()
    {
        $this->activeCurriculum = Curriculum::where('is_active', true)
            ->first();

        if (!$this->activeCurriculum) {
            session()->flash('alert', true);
            session()->flash('alert-type', 'warning');
            session()->flash('msg', __('There is no active curriculum. Please activate the curriculum first.'));

            return to_route('staff.curriculum');
        }

        $this->semesters = collect(range(1, 8))
            ->map(fn ($semester) => [
                'title' => __('Semester :1', ['1' => $semester]),
                'value' => $semester
            ])->toArray();

        $this->semester = 'all';
    }

    public function render()
    {
        $courses = Course::with('curriculum')
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->where('curriculum_id', $this->activeCurriculum->id);

        if ($this->semester != 'all') {
            $courses = $courses->where('semester', $this->semester);
        }

        $courses = $courses
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->orderBy('semester', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('pages.staff.course.index', compact('courses'))
            ->title(__('Course'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
