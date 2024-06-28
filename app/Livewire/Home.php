<?php

namespace App\Livewire;

use App\Models\Room;
use App\Models\Staff;
use App\Models\Course;
use App\Enums\UserType;
use App\Models\Lecture;
use App\Models\Student;
use Livewire\Component;
use App\Models\Lecturer;
use App\Models\Register;
use App\Models\Curriculum;
use App\Models\Payment;
use App\Repository\StudentRepository;
use App\Repository\LecturerRepository;

class Home extends Component
{
    public array $colors;
    public function mount()
    {
        $this->colors = [
            'primary',
            'green',
            'lotus',
            'lime',
            'purple',
            'red',
            'scampi',
            'yellow',
        ];
    }
    public function render()
    {
        if (auth()->user()->role == UserType::student->name)
            return $this->studentView();
        elseif (auth()->user()->role == UserType::lecturer->name)
            return $this->lecturerView();
        elseif (auth()->user()->role == UserType::staff->name)
            return $this->staffView();
        else
            return $this->redirectRoute('logout');
    }

    public function studentView()
    {
        $student = StudentRepository::getStudent(auth()->user()->data->id);
        $semester = $student['data']['semester'];

        $css = !empty(collect($student['course_selection_sheets'])
            ->where('semester', $semester)->first()['data']) ?
            collect($student['course_selection_sheets'])
                ->where('semester', $semester)->first()['data']['details'] : null;

        $schedules = collect($css)->where('day', \Carbon\Carbon::now()->dayName);

        return view('pages.home.student', [
            'student' => $student,
            'schedules' => $schedules
        ])
            ->title(__('Home'));
    }

    public function lecturerView()
    {
        $guidancesStudent = auth()->user()->data->students()->count();
        $studentsPassed = auth()->user()->data->students()->whereHas('passed')->count();
        $activeStudents = auth()->user()->data->students()->whereDoesntHave('passed')->count();

        $schedules = LecturerRepository::getTodaysSchedule(auth()->user()->data);
        return view('pages.home.lecturer', [
            'guidancesStudent' => $guidancesStudent,
            'studentsPassed' => $studentsPassed,
            'activeStudents' => $activeStudents,
            'schedules' => $schedules
        ])
            ->title(__('Home'));
    }

    public function staffView()
    {
        $rooms = Room::count();
        $curricula = Curriculum::count();
        $courses = Course::count();
        $lectures = Lecture::count();

        $students = new Student();
        $allStudents = $students->replicate()->count();
        $studentsPassed = $students->replicate()->whereHas('passed')->count();
        $activeStudents = $students->replicate()->whereDoesntHave('passed')->count();
        $studentsNotRegistered = Register::count();
        $staff = Staff::count();
        $lecturers = Lecturer::count();
        $payments = Payment::count();

        return view('pages.home.staff', [
            'allStudents' => $allStudents,
            'studentsPassed' => $studentsPassed,
            'activeStudents' => $activeStudents,
            'studentsNotRegistered' => $studentsNotRegistered,
            'staff' => $staff,
            'lecturers' => $lecturers,
            'rooms' => $rooms,
            'courses' => $courses,
            'lectures' => $lectures,
            'payments' => $payments,
            'curricula' => $curricula,
        ])->title(__('Home'));
    }
}
