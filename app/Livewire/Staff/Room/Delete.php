<?php

namespace App\Livewire\Staff\Room;

use App\Models\Room;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDeleteRoom', 'clearModal'];

    public ?Room $room = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.room.delete');
    }

    public function setDeleteRoom(Room $room)
    {
        $this->clearModal();
        $this->room = $room;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function destroy()
    {
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            $this->room->delete();

            $this->dispatch('refreshRoom');
            $this->dispatch('toggle-delete-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Room')])]);
            DB::commit();
            $this->isLoading = false;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
