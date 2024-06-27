<?php

namespace App\Livewire\Staff\Lecture;

use App\Models\Lecture;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDeleteLecture', 'clearModal'];

    public ?Lecture $lecture = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.lecture.delete');
    }

    public function setDeleteLecture(Lecture $lecture)
    {
        $this->clearModal();
        $this->lecture = $lecture;
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
            $this->lecture->delete();

            $this->dispatch('refreshLecture');
            $this->dispatch('toggle-delete-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Lecture')])]);
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
