<?php

namespace App\Livewire\Users;

use App\Helpers\WaHelper;
use App\Jobs\WaSender;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ForgotPassword extends Component
{
    use LivewireAlert;
    protected $listeners = ['setForgotPassword', 'clearModal'];

    public $user;
    public $result;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.users.forgot-password');
    }

    public function setForgotPassword(User $user)
    {
        $this->isLoading = true;
        $this->user = $user;
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function submit()
    {
        $this->isLoading = true;
        try {
            $newPassword = $this->user->data->id;
            $this->user->update([
                'password' => bcrypt($newPassword)
            ]);

            $this->result = [
                'new_password' => $newPassword
            ];

            WaSender::dispatch(WaHelper::getTemplate('forgot_password', [
                'id' => $this->user->data->id, 'name' => $this->user->data->name, 'new_password' => $newPassword
            ]), $this->user->data->phone_number);
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Password')])]);
            $this->isLoading = false;
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
