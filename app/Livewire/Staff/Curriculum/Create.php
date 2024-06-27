<?php

namespace App\Livewire\Staff\Curriculum;

use App\Models\Curriculum;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;
    protected $listeners = ['clearModal'];

    public string $name;
    public string $description;
    public string $year;
    public string $code;

    public bool $isLoading = false;

    public function render()
    {
        return view('pages.staff.curriculum.create');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'description' => 'required|string|max:200',
            'code' => 'required|string|max:10|unique:rooms,code',
            'year' => 'required|numeric|digits:4'
        ];
    }

    public function validationAttributes()
    {
        return [
            'code' => __(':code Code', ['code' => __('Curriculum')]),
            'name' => __(':name Name', ['name' => __('Curriculum')]),
            'description' => __('Description'),
            'year' => __('Year')
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
            Curriculum::create([
                'code' => $this->code,
                'name' => $this->name,
                'year' => $this->year,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->refresh();
            $this->dispatch('refreshCurriculum');
            $this->dispatch('toggle-create-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Curriculum')])]);
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
