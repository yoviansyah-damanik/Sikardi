<?php

namespace App\Livewire\Staff;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Lecturer extends Component
{
    use WithPagination;

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
}
