<?php

namespace App\Livewire\Staff\Room;

use App\Models\Room;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshRoom' => '$refresh'];

    #[Url]
    public ?string $search = null;

    public function render()
    {
        $rooms = Room::with('lectures')
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->paginate(15);

        return view('pages.staff.room.index', compact('rooms'))
            ->title(__('Room'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }
}
