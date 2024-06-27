<?php

namespace App\Livewire\Student;

use App\Helpers\WaHelper;
use App\Jobs\WaSender;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignSupervisor extends Component
{
    use LivewireAlert;
    protected $listeners = ['setAssignSupervisor', 'clearModal'];

    public $lecturers;
    public ?Student $student = null;
    public bool $isLoading = true;
    public $supervisor;
    public $selected_supervisor;

    public function render()
    {
        return view('pages.student.assign-supervisor');
    }

    public function setSupervisor()
    {
        $this->supervisor = Lecturer::whereHas('user', fn ($q) => $q->where('is_suspended', false))
            ->orderBy('name')
            ->get()
            ->map(fn ($supervisor) => ['value' => $supervisor->id, 'title' => $supervisor->id . " | " . $supervisor->name])
            ->toArray();
        $this->selected_supervisor = $this->student->supervisorThrough ? $this->student->supervisorThrough->lecturer_id : (!empty($this->supervisor[0]['value']) ? $this->supervisor[0]['value'] : null);
    }

    public function setAssignSupervisor(Student $student)
    {
        $this->isLoading = true;
        $this->reset();
        $this->student = $student->load('supervisorThrough', 'supervisor');
        $this->setSupervisor();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function rules()
    {
        return [
            'selected_supervisor' => [
                'required',
                Rule::in(collect($this->supervisor)->pluck('value'))
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'selected_supervisor' => __('Supervisor :1', ['1' => 1]),
        ];
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $this->student->supervisorThrough()->delete();

            $this->student->supervisorThrough()->create([
                'lecturer_id' => $this->selected_supervisor,
            ]);

            $this->student->refresh();
            WaSender::dispatch(
                WaHelper::getTemplate('assign_supervisor', [
                    'lecturer_id' => $this->student->supervisor->id,
                    'lecturer_name' => $this->student->supervisor->name,
                    'as' => __('Supervisor'),
                    'npm' => $this->student->id,
                    'name' => $this->student->name
                ]),
                $this->student->supervisor->phone_number
            );

            WaSender::dispatch(
                WaHelper::getTemplate('assign_supervisor_student', [
                    'nidn' => $this->student->supervisor->id,
                    'name' => $this->student->supervisor->name,
                ]),
                $this->student->phone_number
            );

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('refreshStudents');
            $this->dispatch('toggle-assign-supervisor-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Student')])]);
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
