<?php

namespace App\Livewire\Staff\Room;

use App\Models\Room;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEditRoom', 'clearModal'];

    public string $name;
    public string $description;
    public string $code;

    public ?Room $room = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.room.edit');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:200',
            'code' => 'required|string|max:10|unique:rooms,code,' . $this->room->id
        ];
    }

    public function validationAttributes()
    {
        return [
            'code' => __(':code Code', ['code' => __('Room')]),
            'name' => __(':name Name', ['name' => __('Room')]),
            'description' => __('Description'),
        ];
    }

    public function setEditRoom(Room $room)
    {
        $this->isLoading = true;
        $this->resetValidation();
        $this->room = $room;
        $this->name = $room->name;
        $this->description = $room->description;
        $this->code = $room->code;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            $this->room->update([
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->reset();
            $this->dispatch('refreshRoom');
            $this->dispatch('toggle-create-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Room')])]);
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
