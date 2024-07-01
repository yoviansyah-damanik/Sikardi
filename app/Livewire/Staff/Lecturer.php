<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Helpers\DownloadHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Lecturer extends Component
{
    use WithPagination, LivewireAlert;

    protected $listeners = [
        'refreshLecturers' => '$refresh',
        'refreshUserActivation' => '$refresh',
        'setSearch'
    ];

    #[Url]
    public string $search = '';

    public array $activationTypes;

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
        $this->activationType = $this->activationTypes[0]['value'];
    }

    public function render()
    {
        $lecturers = \App\Models\Lecturer::with('user', 'students')
            ->whereAny(['id', 'name'], 'like', $this->search . "%");

        if ($this->activationType != 'all') {
            $lecturers = $lecturers->whereHas('user', fn ($q) => $q->where('is_suspended', $this->activationType == 'suspended' ? true : false));
        }

        $lecturers = $lecturers->paginate(15);

        return view('pages.staff.lecturer', compact('lecturers'))
            ->title(__('Lecturers'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function download()
    {
        try {
            $lecturers = \App\Models\Lecturer::all();

            if (!count($lecturers)) {
                $this->alert('error', __('No :data found.', ['data' => __('Lecturer')]));
                return;
            }

            $download = DownloadHelper::downloadPdf(
                'all-lecturers',
                [
                    'lecturers' => $lecturers,
                ],
                __(':data Data', ['data' => __('All Lecturers')]) . ' ' . \Carbon\Carbon::now()->year
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
