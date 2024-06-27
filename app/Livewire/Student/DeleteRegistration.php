<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Register;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DeleteRegistration extends Component
{
    use LivewireAlert;
    protected $listeners = ['setDeleteRegistration', 'clearModal'];

    public ?Register $register = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.student.delete-registration');
    }

    public function setDeleteRegistration(Register $register)
    {
        $this->clearModal();
        $this->register = $register;
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
            $this->register->delete();

            $this->dispatch('refreshStudents');
            $this->dispatch('toggle-delete-registration-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute deleted successfully.', ['attribute' => __('Registration')])]);

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
