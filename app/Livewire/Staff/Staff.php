<?php

namespace App\Livewire\Staff;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Staff extends Component
{
    use WithPagination;
    protected $listeners = [
        'refreshStaff' => '$refresh',
        'refreshUserActivation' => '$refresh',
        'setSearch'
    ];

    #[Url]
    public string $search = '';

    public function render()
    {
        $staff = \App\Models\Staff::with('user')
            ->whereAny(['id', 'name'], 'like', $this->search . "%")
            ->paginate(15);

        return view('pages.staff.staff', compact('staff'))
            ->title(__('Staff'));
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
