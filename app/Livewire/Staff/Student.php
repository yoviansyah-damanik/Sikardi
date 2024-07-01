<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use App\Models\Register;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Helpers\DownloadHelper;
use App\Repository\StudentRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Student extends Component
{
    use WithPagination, LivewireAlert;

    protected $listeners = [
        'refreshStudents' => '$refresh',
        'refreshUserActivation' => '$refresh',
        'setSearch',
        'setViewActive',
    ];

    #[Url]
    public string $search = '';

    #[Url]
    public string $viewActive;

    public int $limit = 15;
    public array $activationTypes;
    public array $viewList;

    #[Url]
    public string $activationType;

    public function mount()
    {
        $this->activationTypes = [
            [
                'title' => __('All'),
                'value' => 'all'
            ],
            [
                'title' => __('Active'),
                'value' => 'active'
            ],
            [
                'title' => __('Suspended'),
                'value' => 'suspended'
            ],
        ];

        $this->activationType = !in_array(request()->activationType, collect($this->activationTypes)->pluck('value')->toArray()) || !request()->activationType ? $this->activationTypes[0]['value'] : request()->activationType;

        $this->viewList = ['registered_students', 'student_registration', 'students_passed'];
        $this->viewActive = !in_array(request()->viewActive, $this->viewList) || !request()->viewActive ? $this->viewList[0] : request()->viewActive;
    }

    public function render()
    {
        if ($this->viewActive == 'registered_students') {
            $students = StudentRepository::getAll(limit: $this->limit, search: $this->search, searchColumns: ['id', 'name'], activationType: $this->activationType, passType: 'not_yet_passed');
        } elseif ($this->viewActive == 'student_registration') {
            $students = Register::whereAny(['student_id', 'name'], 'like', "$this->search%")
                ->paginate(15);
        } else {
            $students = StudentRepository::getAll(limit: $this->limit, search: $this->search, searchColumns: ['id', 'name'], activationType: $this->activationType, passType: 'passed');
        }

        return view('pages.staff.student', ['students' => $students])
            ->title(__('Students'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function setViewActive($viewActive)
    {
        $this->viewActive = $viewActive;
    }

    public function download()
    {
        try {
            $students = StudentRepository::getAll(passType: 'not_yet_passed');

            if (!count($students)) {
                $this->alert('error', __('No :data found.', ['data' => __('Student')]));
                return;
            }

            $download = DownloadHelper::downloadPdf(
                'all-students',
                [
                    'students' => $students,
                ],
                __(':data Data', ['data' => __('All Students')]) . ' ' . \Carbon\Carbon::now()->year
            );

            if (is_string($download)) {
                $this->alert('warning', $download);
                return;
            }

            return $download;
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
