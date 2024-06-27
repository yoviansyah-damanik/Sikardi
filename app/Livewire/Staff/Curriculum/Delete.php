<?php

namespace App\Livewire\Staff\Curriculum;

use Livewire\Component;
use App\Models\Curriculum;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDeleteCurriculum', 'clearModal'];

    public ?Curriculum $curriculum = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.curriculum.delete');
    }

    public function setDeleteCurriculum(Curriculum $curriculum)
    {
        $this->clearModal();
        $this->curriculum = $curriculum;
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
            $this->curriculum->delete();

            $this->dispatch('refreshCurriculum');
            $this->dispatch('toggle-delete-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Curriculum')])]);
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
