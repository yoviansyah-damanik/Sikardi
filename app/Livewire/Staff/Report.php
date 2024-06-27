<?php

namespace App\Livewire\Staff;

use App\Helpers\DownloadHelper;
use App\Models\Staff;
use Livewire\Component;
use App\Models\Lecturer;
use App\Repository\StudentRepository;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Report extends Component
{
    use LivewireAlert;

    public array $types;
    public array $typesGroup;
    public array $availableTypes;

    public int $month;
    public int $year;

    public array $months;

    public string $type;
    public string $typeGroup;

    public bool $isLoading = false;

    public function mount()
    {
        $this->months = [
            ['title' => __("January"), 'value' => '1'],
            ['title' => __("February"), 'value' => '2'],
            ['title' => __("March"), 'value' => '3'],
            ['title' => __("April"), 'value' => '4'],
            ['title' => __("May"), 'value' => '5'],
            ['title' => __("June"), 'value' => '6'],
            ['title' => __("July"), 'value' => '7'],
            ['title' => __("August"), 'value' => '8'],
            ['title' => __("September"), 'value' => '9'],
            ['title' => __("October"), 'value' => '10'],
            ['title' => __("November"), 'value' => '11'],
            ['title' => __("December"), 'value' => '12'],
        ];

        $this->availableTypes = [
            'student' => [
                [
                    'title' => __('All Students'),
                    'value' => 'all_students'
                ]
            ],
            'lecturer' => [
                [
                    'title' => __('All Lecturers'),
                    'value' => 'all_lecturers'
                ]
            ],
            'staff' => [
                [
                    'title' => __('All Staff'),
                    'value' => 'all_staff'
                ]
            ]
        ];

        $this->typesGroup = [
            [
                'title' => __('Student'),
                'value' => 'student'
            ],
            [
                'title' => __('Lecturer'),
                'value' => 'lecturer'
            ],
            [
                'title' => __('Staff'),
                'value' => 'staff'
            ],
        ];

        $this->typeGroup = $this->typesGroup[0]['value'];

        $this->month = \Carbon\Carbon::now()->month;
        $this->year = \Carbon\Carbon::now()->year;

        $this->setFilter();
    }

    public function setFilter()
    {
        $this->types = $this->availableTypes[$this->typeGroup];
        $this->type = $this->types[0]['value'];
    }

    public function render()
    {
        return view('pages.staff.report')
            ->title(__('Report'));
    }

    public function print()
    {
        $this->isLoading = true;
        try {
            if ($this->type == 'all_students') {
                $filename = __(':data Data', ['data' => __('All Students')]);
                $view = 'all_students';
                $paper = 'A4';
                $paperOrientation = 'landscape';
                $data = [
                    'students' => StudentRepository::getAll(passType: 'not_yet_passed'),
                    'orientation' => $paperOrientation
                ];
            } elseif ($this->type == 'all_lecturers') {
                $filename = __(':data Data', ['data' => __('All Lecturers')]);
                $view = 'all_lecturers';
                $paper = 'A4';
                $paperOrientation = 'landscape';
                $data = [
                    'lecturers' => Lecturer::all(),
                    'orientation' => $paperOrientation
                ];
            } elseif ($this->type == 'all_staff') {
                $filename = __(':data Data', ['data' => __('All Staff')]);
                $view = 'all_staff';
                $paper = 'A4';
                $paperOrientation = 'landscape';
                $data = [
                    'staff' => Staff::all(),
                    'orientation' => $paperOrientation
                ];
            } else {
                $this->alert('warning', 'Maunya kamu apaaasihhhh!!!');
                return;
            }

            $this->isLoading = false;

            return DownloadHelper::downloadPdf($view, $data, \Carbon\Carbon::now()->timestamp . '_' . Str::replace(' ', '_', $filename), $paper, $paperOrientation);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
