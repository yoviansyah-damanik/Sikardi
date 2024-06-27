<?php

namespace App\Livewire\Account;

use Livewire\Component;
use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Staff extends Component
{
    use LivewireAlert;

    public string $name;
    public string $gender;
    public string $phoneNumber;

    public array $genders;
    public bool $isLoading = false;

    public function mount()
    {
        $this->genders = [
            [
                'label' => __('Male'),
                'value' => 'L'
            ],
            [
                'label' => __('Female'),
                'value' => 'P'
            ]
        ];

        $this->name = auth()->user()->data->name;
        $this->gender = auth()->user()->data->gender;
        $this->phoneNumber = auth()->user()->data->phone_number;
    }

    public function render()
    {
        return view('pages.account.staff');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:40',
            'gender' => [
                'required',
                Rule::in(collect($this->genders)->pluck('value')->toArray())
            ],
            'phoneNumber' => ['required', new PhoneNumber]
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => __('Fullname'),
            'gender' => __('Gender'),
            'phoneNumber' => __('Phone Number')
        ];
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            auth()->user()->data->update([
                'name' => $this->name,
                'gender' => $this->gender,
                'phone_number' => $this->phoneNumber,
            ]);

            DB::commit();
            $this->alert('success', __('Successfully'), ['text' => __(':attribute updated successfully.', ['attribute' => __('Account')])]);
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
