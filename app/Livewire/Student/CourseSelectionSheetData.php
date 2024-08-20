<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Helpers\DownloadHelper;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CourseSelectionSheetData extends Component
{
    use LivewireAlert;
    public $cssId;
    public $student;
    public $approveDelete;
    public $courseSelectionSheet;
    public $paymentStatus;

    #[Reactive]
    public int $semester = 1;

    protected $listeners = ['clearModal'];

    public function mount($student, ?int $semester = null)
    {
        $this->student = $student;
        $this->semester = $semester ?? $student['data']['semester'];
    }

    public function render()
    {
        $this->courseSelectionSheet = collect($this->student['course_selection_sheets'])
            ->where('semester', $this->semester)
            ->first()['data'];
        $this->paymentStatus = collect($this->student['payments'])
            ->where('semester', $this->semester)
            ->first()['status'];

        $this->cssId = $this->courseSelectionSheet['id'] ?? null;

        return view('pages.student.course-selection-sheet-data');
    }

    public function download()
    {
        try {
            $data = collect($this->student['course_selection_sheets'])
                ->where('semester', $this->semester)
                ->first();

            if (empty($data['data'])) {
                $this->alert('error', __('No data found'));
                return;
            }

            return DownloadHelper::downloadPdf('course-selection-sheet', ['student' => $this->student['data'], 'supervisor' => $this->student['supervisor'], 'data' => $data['data']], __('Course Selection Sheet') . '_' . $this->student['data']['npm'] . '_' . $this->student['data']['name'] . '_Sem ' . $data['semester']);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }

    public function clearModal()
    {
        $this->reset([
            'student',
            'courseSelectionSheet',
            'paymentStatus',
            'cssId',
        ]);
    }

    public function delete()
    {
        $this->validate([
            'approveDelete' => 'accepted'
        ], [], [
            'approveDelete' => __('Approve delete CSS')
        ]);

        DB::beginTransaction();
        try {
            \App\Models\CourseSelectionSheet::whereId($this->cssId)
                ->delete();

            DB::commit();
            $this->dispatch('toggle-show-student-css-modal');
            $this->dispatch('refreshStudents');
            $this->alert('success', __('Successfully'), ['text' => $this->cssId . ' ' . __(':attribute deleted successfully.', ['attribute' => __('Course Selection Sheet')])]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
