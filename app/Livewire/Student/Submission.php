<?php

namespace App\Livewire\Student;

use App\Models\Lecture;
use Livewire\Component;
use App\Helpers\GeneralHelper;
use App\Repository\StudentRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Submission extends Component
{
    use LivewireAlert;

    protected $listeners = ['refreshStudentSubmission' => 'setStudent'];

    public int $limit;
    public int $creditTaken = 0;

    public array $lectureTaken = [];
    public $lectures;
    public $student;

    public bool $isLoading = false;

    public function mount()
    {
        $this->limit = GeneralHelper::ccLimit();
        $whereCondition = GeneralHelper::currentSemester();

        $this->lectures = Lecture::with('course', 'room', 'lecturer')
            ->whereHas('curriculum', fn ($q) => $q->where('is_active', true))
            ->whereHas('course', fn ($q) => $q->whereRaw($whereCondition == 'odd' ? '(semester % 2) > 0' : '(semester % 2) = 0'))
            ->get()
            ->sortBy('course.semester');

        $this->setStudent();
    }

    public function setStudent()
    {
        $this->student = StudentRepository::getStudent(auth()->user()->data->id);

        if (!empty($this->student['submission']) || ($this->student['submission'] && $this->student['submission']['status'] == 'revision')) {
            $this->lectureTaken = collect($this->student['submission']['lectures'])->pluck('id')->toArray();
        }
        $this->countCreditTaken();
    }

    public function render()
    {
        return view('pages.student.submission')
            ->title(__('Submission'));
    }

    public function countCreditTaken()
    {
        $temp = collect($this->lectures->load('course'))
            ->whereIn('id', $this->lectureTaken)
            ->sum('course.credit');

        if ($temp > $this->limit) {
            array_pop($this->lectureTaken);
            $this->alert('warning', __('Cannot choose courses because the number of credits exceeds the limit.'));
            return;
        }

        $this->creditTaken = $temp;
    }

    public function openSubmissionConfirmation()
    {
        $this->dispatch(
            'setSubmissionConfirmation',
            collect($this->lectures->load('course', 'lecturer', 'room')->append(['day_name', 'remainder']))
                ->whereIn('id', $this->lectureTaken)
                ->sortBy('day'),
            $this->limit
        );
    }
}
