<?php

namespace App\Livewire\Lecturer;

use App\Jobs\WaSender;
use Livewire\Component;
use App\Enums\CssStatus;
use App\Helpers\WaHelper;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSelectionSheet;
use App\Repository\StudentRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ApprovalConfirmation extends Component
{
    use LivewireAlert;
    protected $listeners = ['setApprovalConfirmation', 'clearModal'];
    public array $student;

    public array $statusTypes;
    public string $statusType;

    public ?string $message;
    public bool $isLoading = true;

    public function mount()
    {
        $this->statusTypes =  collect(CssStatus::names())->filter(fn ($q) => $q != CssStatus::waiting->name)->toArray();
    }

    public function setApprovalConfirmation(String $student)
    {
        $this->isLoading = true;

        $this->student = StudentRepository::getStudent($student);

        $this->statusType = !empty($this->student['submission']) || ($this->student['submission'] && $this->student['submission']['status'] == 'revision')
            ? $this->student['submission']['status']
            : $this->statusTypes[0];

        $this->message = !empty($this->student['submission']) || ($this->student['submission'] && $this->student['submission']['status'] == 'revision')
            ? $this->student['submission']['message']
            : '';

        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset(
            'statusType',
            'message'
        );
        $this->isLoading = true;
    }

    public function render()
    {
        return view('pages.lecturer.approval-confirmation');
    }

    public function rules()
    {
        return [
            'statusType' => [
                'required',
                Rule::in($this->statusTypes)
            ],
            'message' => 'required|string|max:200'
        ];
    }

    public function validationAttributes()
    {
        return [
            'statusType' => __(':type Type', ['type' => __('Status')]),
            'message' => __('Message')
        ];
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            CourseSelectionSheet::updateOrCreate(['id' => $this->student['submission']['id']], [
                'status' => $this->statusType,
                'message' => $this->message,
                'lecturer_id' => auth()->user()->data->id
            ]);

            WaSender::dispatch(WaHelper::getTemplate('approval_confirmation', [
                'nidn' => auth()->user()->data->id,
                'lecturer' => auth()->user()->data->name,
                'status' => __(Str::headline($this->statusType)),
                'time' => \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s'),
                'message' => $this->message
            ]), $this->student['data']['phone_number']);

            DB::commit();
            $this->dispatch('refreshApproval');
            $this->dispatch('toggle-approval-confirmation-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Submission')])]);
            $this->isLoading = false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->isLoading = false;
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->isLoading = false;
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
