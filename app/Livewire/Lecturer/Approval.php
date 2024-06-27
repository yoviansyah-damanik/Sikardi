<?php

namespace App\Livewire\Lecturer;

use App\Models\Student;
use App\Repository\StudentRepository;
use Livewire\Component;

class Approval extends Component
{
    protected $listeners = ['refreshApproval'];
    public $studentData;
    public $student;

    public function mount(Student $student)
    {
        $this->studentData = $student;
        $this->refreshApproval();
    }

    public function refreshApproval()
    {
        $this->student = StudentRepository::getStudent($this->studentData);
    }

    public function render()
    {
        return view('pages.lecturer.approval')
            ->title(__('Confirm Submission'));
    }
}
