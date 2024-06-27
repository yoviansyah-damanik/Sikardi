<?php

namespace App\Livewire\Student;

use App\Models\Student;
use App\Repository\StudentRepository;
use Livewire\Component;

class ShowData extends Component
{
    public $student;

    protected $listeners = ['setStudent', 'clearModal'];

    public bool $isLoading = true;


    public function render()
    {
        return view('pages.student.show-data');
    }

    public function setStudent($student)
    {
        $this->isLoading = true;
        $this->reset('student');
        $this->student = StudentRepository::getStudent($student);
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset('student');
        $this->isLoading = true;
    }
}
