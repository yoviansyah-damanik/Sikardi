<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UserActivation extends Component
{
    use LivewireAlert;
    protected $listeners = ['setUserActivation', 'clearModal'];

    public ?User $user = null;
    public bool $isLoading = true;
    public array $activationTypes;
    public string $activationType;

    public function mount()
    {
        $this->activationTypes = [
            [
                'label' => 'active',
                'code' => 0
            ],
            [
                'label' => 'suspend',
                'code' => 1
            ],
        ];
    }

    public function render()
    {
        return view('pages.users.user-activation');
    }

    public function rules()
    {
        return [
            'activationType' => [
                'required',
                Rule::in(collect($this->activationTypes)->pluck('code')->toArray())
            ]
        ];
    }

    public function validationAttributes()
    {
        return [
            'activationType' => __('Activation Type'),
        ];
    }

    public function setUserActivation(User $user)
    {
        $this->clearModal();
        $this->user = $user;
        $this->activationType = $user->is_suspended;
        $this->isLoading = false;

        if ($user->role == 'staff') {
            $this->clearModal();
            $this->dispatch('toggle-user-activation-modal');
            $this->alert('warning', __('Accounts of this type cannot be renewed.'));
        }
    }

    public function clearModal()
    {
        $this->reset('activationType', 'user');
        $this->isLoading = true;
    }

    public function save()
    {
        $this->isLoading = true;
        $this->validate();
        DB::beginTransaction();
        try {
            $this->user->update(['is_suspended' => $this->activationType]);

            DB::commit();
            $this->isLoading = false;
            $this->dispatch('refreshUserActivation');
            $this->dispatch('toggle-user-activation-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('User')])]);
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
