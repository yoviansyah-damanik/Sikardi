<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->group(function () {
        Route::get('/login', App\Livewire\Auth\Login::class)
            ->name('login');
        Route::get('/register', App\Livewire\Auth\Register::class)
            ->name('register');
    });

Route::middleware('auth')
    ->group(function () {
        Route::get('/', \App\Livewire\Home::class)
            ->name('home');


        // STAFF ONLY
        Route::as('staff.')
            ->prefix('staff')
            ->middleware('userType:staff')
            ->group(function () {
                Route::get('/student', \App\Livewire\Staff\Student::class)
                    ->name('student');
                Route::get('/lecturer', \App\Livewire\Staff\Lecturer::class)
                    ->name('lecturer');
                Route::get('/staff', \App\Livewire\Staff\Staff::class)
                    ->name('staff');
                Route::get('/payment', \App\Livewire\Staff\Payment\Index::class)
                    ->name('payment');
                Route::get('/curriculum', \App\Livewire\Staff\Curriculum\Index::class)
                    ->name('curriculum');
                Route::get('/course', \App\Livewire\Staff\Course\Index::class)
                    ->name('course');
                Route::get('/room', \App\Livewire\Staff\Room\Index::class)
                    ->name('room');
                Route::get('/lecture', \App\Livewire\Staff\Lecture\Index::class)
                    ->name('lecture');
                Route::get('/configuration', \App\Livewire\Staff\Configuration::class)
                    ->name('configuration');
            });

        // LECTURER ONLY
        Route::as('lecturer.')
            ->prefix('lecturer')
            ->middleware('userType:lecturer')
            ->group(function () {
                Route::get('/student', \App\Livewire\Lecturer\Student::class)
                    ->name('student');
                Route::get('/schedule', \App\Livewire\Lecturer\Schedule::class)
                    ->name('schedule');
                Route::get('/student-submission', \App\Livewire\Lecturer\StudentSubmission::class)
                    ->name('student-submission');
                Route::get('/student-submission/{student:id}', \App\Livewire\Lecturer\Approval::class)
                    ->name('student-submission.approval');
            });

        // STUDENT ONLY
        Route::as('student.')
            ->prefix('student')
            ->middleware('userType:student')
            ->group(function () {
                Route::get('/submission', \App\Livewire\Student\Submission::class)
                    ->middleware('studentCheck')
                    ->name('submission');
                Route::get('/course-selection-sheet', \App\Livewire\Student\CourseSelectionSheet::class)
                    ->name('course-selection-sheet');
                Route::get('/payment', \App\Livewire\Student\Payment\Index::class)
                    ->name('payment');
            });

        Route::get('/users', \App\Livewire\Users\Index::class)
            ->name('users');

        Route::get('/account', \App\Livewire\Account\Index::class)
            ->name('account');

        Route::get('/logout', \App\Livewire\Auth\Logout::class)
            ->name('logout');
    });
