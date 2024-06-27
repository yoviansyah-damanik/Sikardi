<?php

namespace App\Livewire\Staff\Curriculum;

use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use LivewireAlert;
    protected $listeners = ['setEditCurriculum', 'clearModal'];

    public string $name;
    public string $description;
    public string $year;
    public string $code;

    public ?Curriculum $curriculum = null;

    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.curriculum.edit');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:200',
            'code' => 'required|string|max:10|unique:rooms,code,' . $this->curriculum->id,
            'year' => 'required|numeric|digits:4'
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => __(':name Name', ['name' => __('Curriculum')]),
            'description' => __('Description'),
            'year' => __('Year')
        ];
    }

    public function setEditCurriculum(Curriculum $curriculum)
    {
        $this->isLoading = true;
        $this->resetValidation();
        $this->curriculum = $curriculum;
        $this->code = $curriculum->code;
        $this->name = $curriculum->name;
        $this->description = $curriculum->description;
        $this->year = $curriculum->year;
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
            $this->curriculum->update([
                'code' => $this->code,
                'name' => $this->name,
                'year' => $this->year,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->reset();
            $this->dispatch('refreshCurriculum');
            $this->dispatch('toggle-edit-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Curriculum')])]);
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
