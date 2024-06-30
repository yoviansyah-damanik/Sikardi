<?php

namespace App\Livewire\Staff\Course;

use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['clearModal'];

    public bool $isLoading = false;

    public ?Curriculum $activeCurriculum = null;
    public array $semesters;
    public string $curriculum;
    public string $name;
    public string $description;
    public string $code;
    public int $credit;
    public int $semester;

    public function mount(Curriculum $activeCurriculum, $semesters)
    {
        $this->activeCurriculum = $activeCurriculum;
        $this->semesters = $semesters;
        $this->semester = $semesters[0]['value'];
    }

    public function render()
    {
        return view('pages.staff.course.create');
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:courses,code',
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:200',
            'credit' => 'required|numeric|min:1|max:10',
            'semester' => 'required|numeric|min:1|max:8'
        ];
    }

    public function validationAttributes()
    {
        return [
            'code' => __(':code Code', ['code' => __('Course')]),
            'name' => __(':name Name', ['name' => __('Course')]),
            'description' => __('Description'),
            'credit' => __('Course Credits (CC)'),
            'semester' => __('Semester')
        ];
    }

    public function refresh()
    {
        $this->reset(
            'code',
            'description',
            'name',
            'credit',
            'semester'
        );
        $this->semester = $this->semesters[0]['value'];
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            Course::create([
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
                'curriculum_id' => $this->activeCurriculum->id,
                'credit' => $this->credit,
                'semester' => $this->semester,
            ]);

            DB::commit();
            $this->refresh();
            $this->dispatch('refreshCourse');
            $this->dispatch('toggle-create-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Course')])]);
            $this->isLoading = false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
