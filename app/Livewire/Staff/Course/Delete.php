<?php

namespace App\Livewire\Staff\Course;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Delete extends Component
{
    use LivewireAlert;

    protected $listeners = ['setDeleteCourse', 'clearModal'];

    public ?Course $course = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.staff.course.delete');
    }

    public function setDeleteCourse(Course $course)
    {
        $this->clearModal();
        $this->course = $course;
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
            $this->course->delete();

            $this->dispatch('refreshCourse');
            $this->dispatch('toggle-delete-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Course')])]);
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
