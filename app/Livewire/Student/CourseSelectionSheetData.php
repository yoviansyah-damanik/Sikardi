<?php

namespace App\Livewire\Student;

use App\Helpers\DownloadHelper;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\PDF;
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
        $course_selection_sheet = collect($this->student['course_selection_sheets'])
            ->where('semester', $this->semester)
            ->first()['data'];

        return view('pages.student.course-selection-sheet-data', compact('course_selection_sheet'));
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
