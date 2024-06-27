<?php

namespace App\Livewire\Staff\Room;

use App\Models\Room;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['clearModal'];

    public string $name;
    public string $description;
    public string $code;

    public bool $isLoading = false;

    public function render()
    {
        return view('pages.staff.room.create');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:200',
            'code' => 'required|string|max:10|unique:rooms,code'
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

    public function refresh()
    {
        $this->reset();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            Room::create([
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->refresh();
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
