<?php

namespace App\Livewire\Student;

use App\Enums\CssStatus;
use App\Jobs\WaSender;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Helpers\GeneralHelper;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSelectionSheet;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SubmissionConfirmation extends Component
{
    use LivewireAlert;

    protected $listeners = ['setSubmissionConfirmation', 'clearModal'];

    public $submissions;
    public bool $isLoading = true;

    public int $totalCredit = 0;
    public int $limit = 0;

    public function render()
    {
        return view('pages.student.submission-confirmation');
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function setSubmissionConfirmation($submissions, $limit)
    {
        $this->isLoading = true;
        $this->submissions = $submissions;
        $this->limit = $limit;
        $this->totalCredit = collect($submissions)->sum('course.credit');
        $this->isLoading = false;
    }

    public function checkRemainder()
    {
        return collect($this->submissions)
            ->every(fn ($submission) => $submission['remainder'] > 0);
    }

    public function submit()
    {
        if (!$this->checkRemainder()) {
            $this->alert('warning', __('There are several learning classes that are full. Please check your options again.'));
            return;
        }

        DB::beginTransaction();
        try {
            $css = CourseSelectionSheet::updateOrCreate(
                [
                    'student_id' => auth()->user()->data->id,
                    'semester' => auth()->user()->data->semester,
                    'year' => \Carbon\Carbon::now()->year,
                    'type' => GeneralHelper::currentSemester(),
                ],
                [
                    'status' => CssStatus::waiting->name,
                    'max_load' => GeneralHelper::ccLimit()
                ]
            );

            if ($css->details()->count() > 0)
                $css->details()->delete();

            foreach ($this->submissions as $submission) {
                $css->details()->create([
                    'lecture_id' => $submission['id'],
                    'course_id' => $submission['course_id'],
                    'room_id' => $submission['room_id'],
                    'lecturer_id' => $submission['lecturer_id'],
                    'limit' => $submission['limit'],
                    'day' => $submission['day'],
                    'start_time' => $submission['start_time'],
                    'end_time' => $submission['end_time'],
                ]);
            }

            WaSender::dispatch(
                WaHelper::getTemplate(
                    'create_submission',
                    [
                        'name' => auth()->user()->data->name,
                        'npm' => auth()->user()->data->id,
                        'cc' => $this->totalCredit,
                        'semester' => auth()->user()->data->semester,
                        'time' => \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s')
                    ]
                ),
                auth()->user()->data->supervisor->phone_number
            );
            DB::commit();
            $this->dispatch('toggle-submission-confirmation-modal');
            $this->dispatch('refreshStudentSubmission');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Submission')])]);
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
