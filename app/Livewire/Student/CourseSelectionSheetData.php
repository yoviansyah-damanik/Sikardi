<?php

namespace App\Livewire\Student;

use App\Helpers\DownloadHelper;
use Livewire\Component;
use Livewire\Attributes\Reactive;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CourseSelectionSheetData extends Component
{
    use LivewireAlert;
    public $student;

    #[Reactive]
    public int $semester = 1;

    public function mount($student, ?int $semester = null)
    {
        $this->student = $student;
        $this->semester = $semester ?? $student['data']['semester'];
    }

    public function render()
    {
        $courseSelectionSheet = collect($this->student['course_selection_sheets'])
            ->where('semester', $this->semester)
            ->first()['data'];

        $paymentStatus = collect($this->student['payments'])
            ->where('semester', $this->semester)
            ->first()['status'];

        return view('pages.student.course-selection-sheet-data', compact('courseSelectionSheet', 'paymentStatus'));
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
}
