<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $menu_group = [
            [
                [
                    'title' => __('Home'),
                    'icon' => 'i-ph-fire',
                    'to' => route('home'),
                    'isActive' => request()->routeIs('home')
                ]
            ],
        ];

        if (auth()->user()->role == 'staff') {
            $menu_group[] = [
                [
                    'title' => __('Student'),
                    'icon' => 'i-ph-student',
                    'to' => route('staff.student'),
                    'isActive' => request()->routeIs('staff.student')
                ],
                [
                    'title' => __('Lecturer'),
                    'icon' => 'i-ph-chalkboard-teacher-fill',
                    'to' => route('staff.lecturer'),
                    'isActive' => request()->routeIs('staff.lecturer')
                ],
                [
                    'title' => __('Staff'),
                    'icon' => 'i-ph-lego-smiley',
                    'to' => route('staff.staff'),
                    'isActive' => request()->routeIs('staff.staff')
                ],
            ];

            $menu_group[] = [
                [
                    'title' => __('Room'),
                    'icon' => 'i-ph-house',
                    'to' => route('staff.room'),
                    'isActive' => request()->routeIs('staff.room')
                ],
                [
                    'title' => __('Curriculum'),
                    'icon' => 'i-ph-bookmark',
                    'to' => route('staff.curriculum'),
                    'isActive' => request()->routeIs('staff.curriculum')
                ],
                [
                    'title' => __('Course'),
                    'icon' => 'i-ph-notebook',
                    'to' => route('staff.course'),
                    'isActive' => request()->routeIs('staff.course')
                ],
                [
                    'title' => __('Lecture'),
                    'icon' => 'i-ph-clock-user',
                    'to' => route('staff.lecture'),
                    'isActive' => request()->routeIs('staff.lecture')
                ],
            ];
        } elseif (auth()->user()->role == 'student') {
            $menu_group[] = [
                [
                    'title' => __('Submission'),
                    'icon' => 'i-ph-signature',
                    'to' => route('student.submission'),
                    'isActive' => request()->routeIs('student.submission')
                ],
                [
                    'title' => __('Payment'),
                    'icon' => 'i-ph-money-wavy',
                    'to' => route('student.payment'),
                    'isActive' => request()->routeIs('student.payment')
                ],
                [
                    'title' => __('Course Selection Sheet (CSS)'),
                    'icon' => 'i-ph-list-heart',
                    'to' => route('student.course-selection-sheet'),
                    'isActive' => request()->routeIs('student.course-selection-sheet')
                ],
            ];
        } else {
            $menu_group[] = [
                [
                    'title' => __('Guidance\'s Student'),
                    'icon' => 'i-ph-student',
                    'to' => route('lecturer.student'),
                    'isActive' => request()->routeIs('lecturer.student')
                ],
                [
                    'title' => __('Lecture Schedule'),
                    'icon' => 'i-ph-clock-user',
                    'to' => route('lecturer.schedule'),
                    'isActive' => request()->routeIs('lecturer.schedule*')
                ],
                [
                    'title' => __('Student Submission'),
                    'icon' => 'i-ph-book-open-text',
                    'to' => route('lecturer.student-submission'),
                    'isActive' => request()->routeIs('lecturer.student-submission*')
                ],
            ];
        }

        if (auth()->user()->role == 'staff')
            $menu_group[] = [
                [
                    'title' => __('Payment'),
                    'icon' => 'i-ph-money-wavy',
                    'to' => route('staff.payment'),
                    'isActive' => request()->routeIs('staff.payment')
                ],
                [
                    'title' => __('Users'),
                    'icon' => 'i-ph-users-three',
                    'to' => route('users'),
                    'isActive' => request()->routeIs('users')
                ],
                [
                    'title' => __('Configuration'),
                    'icon' => 'i-ph-wrench',
                    'to' => route('staff.configuration'),
                    'isActive' => request()->routeIs('staff.configuration')
                ],
            ];

        $menu_group[] = [
            [
                'title' => __('Account'),
                'icon' => 'i-ph-user',
                'to' => route('account'),
                'isActive' => request()->routeIs('account')
            ],
        ];

        return view('components.sidebar', compact('menu_group'));
    }
}
