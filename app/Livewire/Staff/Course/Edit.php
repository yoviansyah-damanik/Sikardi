<?php

namespace App\Livewire\Staff\Course;

use App\Models\Course;
use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEditCourse', 'clearModal'];

    public bool $isLoading = true;

    public ?Curriculum $activeCurriculum = null;

    public array $semesters;
    public string $name;
    public string $description;
    public string $code;
    public int $credit;
    public int $semester;

    public ?Course $course = null;

    public function mount($semesters)
    {
        $this->semesters = $semesters;
    }

    public function render()
    {
        return view('pages.staff.course.edit');
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:10|unique:courses,code,' . $this->course->id,
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
            'description' => __('Description'),
            'name' => __(':name Name', ['name' => __('Course')]),
            'credit' => __('Course Credits (CC)'),
            'semester' => __('Semester')
        ];
    }

    public function clearModal()
    {
        $this->reset(
            'code',
            'description',
            'name',
            'credit',
            'semester'
        );
        $this->isLoading = true;
    }

    public function setEditCourse(Course $course)
    {
        $this->isLoading = true;

        $this->code = $course->code;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->credit = $course->credit;
        $this->semester = $course->semester;
        $this->course = $course;

        $this->isLoading = false;
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            $this->course->update([
                'code' => $this->code,
                'name' => $this->name,
                'credit' => $this->credit,
                'semester' => $this->semester,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->reset(
                'code',
                'description',
                'name',
                'credit',
                'semester'
            );
            $this->dispatch('refreshCourse');
            $this->dispatch('toggle-edit-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Course')])]);
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
