<?php

namespace App\Livewire\Student;

use App\Jobs\WaSender;
use App\Models\Student;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Models\StudentPassed;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SetPassStatus extends Component
{
    use LivewireAlert;
    protected $listeners = ['setPassStatus', 'clearModal'];

    public bool $isPass;
    public bool $isLoading = true;

    public array $passTypes;
    public string $passType;

    public float $gpa;

    public ?Student $student = null;

    public function mount()
    {
        $this->passTypes = ['passed', 'not_yet_passed'];
        $this->passType = $this->passTypes[0];
    }

    public function render()
    {
        return view('pages.student.set-pass-status');
    }

    public function rules()
    {
        return [
            'gpa' => [Rule::requiredIf($this->passType == 'passed'), 'numeric', 'between:0,4'],
            'passType' => ['required', Rule::in($this->passTypes)],
        ];
    }

    public function validationAttributes()
    {
        return [
            'passType' => __('Pass Type'),
            'gpa' => __('Grade Point Average (GPA)'),
        ];
    }

    public function setPassStatus(Student $student, String $passType)
    {
        $this->isLoading = true;
        $this->clearModal();
        $this->student = $student;
        $this->gpa =  $this->student?->passed?->gpa ?? 0;
        $this->passType = $passType;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset('passType', 'student', 'gpa');
        $this->isLoading = true;
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if ($this->passType == 'passed') {
                StudentPassed::updateOrCreate([
                    'student_id' => $this->student->id,
                ], [
                    'semester' => $this->student->semester,
                    'year' => \Carbon\Carbon::now()->year,
                    'gpa' => $this->gpa,
                ]);

                WaSender::dispatch(
                    WaHelper::getTemplate('student_passed', [
                        'npm' => $this->student->id,
                        'name' => $this->student->name,
                        'gpa' => $this->gpa,
                        'status' => __('Passed')
                    ]),
                    $this->student->phone_number
                );

                $this->dispatch('setViewActive', 'students_passed');
            } else {
                $this->student->passed()->delete();

                WaSender::dispatch(
                    WaHelper::getTemplate('student_passed_change', [
                        'npm' => $this->student->id,
                        'name' => $this->student->name,
                        'status' => __('Not Yet Passed')
                    ]),
                    $this->student->phone_number
                );

                $this->dispatch('setViewActive', 'registered_students');
            }

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('setSearch', $this->student->id);
            $this->dispatch('refreshStudents');
            $this->dispatch('toggle-set-pass-status-modal');
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
