<?php

namespace App\Livewire\Staff\Curriculum;

use Livewire\Component;
use App\Models\Curriculum;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;

    protected $listeners = ['refreshCurriculum' => '$refresh'];

    #[Url]
    public ?string $search = null;

    public function render()
    {
        $curricula = Curriculum::with('courses', 'lectures')
            ->whereAny(['code', 'name'], 'like', $this->search . '%')
            ->orderBy('code', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(15);

        return view('pages.staff.curriculum.index', compact('curricula'))
            ->title(__('Curriculum'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function setActive(Curriculum $curriculum)
    {
        DB::beginTransaction();
        try {
            Curriculum::whereNot('id', $curriculum->id)->update([
                'is_active' => false
            ]);
            $curriculum->update([
                'is_active' => true
            ]);

            DB::commit();
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Curriculum')])]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
