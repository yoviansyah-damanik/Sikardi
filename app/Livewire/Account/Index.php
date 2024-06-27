<?php

namespace App\Livewire\Account;

use Livewire\Component;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use LivewireAlert;

    public string $email;
    public string $newPassword;
    public string $rePassword;
    public string $confPassword;

    public bool $isLoading = false;

    public function mount()
    {
        $this->email = auth()->user()->email;
    }

    public function render()
    {
        return view('pages.account.index')
            ->title(__('Account'));
    }

    public function rules()
    {
        return [
            'email' => 'required|email:dns|unique:users,email,' . auth()->user()->id,
            'newPassword' => [
                'required', 'string',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ],
            'rePassword' => 'required|string|same:newPassword',
            'confPassword' => 'required|current_password',
        ];
    }

    public function validationAttributes()
    {
        return [
            'email' => __('Email'),
            'newPassword' => __('New Password'),
            'rePassword' => __('Re-Password'),
            'confPassword' => __('Confirmation Password'),
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;
        try {
            auth()->user()->update([
                'email' => $this->email,
                'password' => bcrypt($this->newPassword)
            ]);

            $this->reset('newPassword', 'rePassword');

            $this->alert('success', __(':attribute updated successfully.', ['attribute' => __('User')]));
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
