<?php

namespace App\Livewire\Staff;

use App\Helpers\WaHelper;
use App\Jobs\WaSender;
use App\Models\User;
use Livewire\Component;
use App\Models\Staff;
use App\Models\UserType;
use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    protected $listeners = ['clearModal'];
    public array $genders;
    public string $gender;
    public string $identify;
    public string $name;
    public string $email;
    public string $phone_number;

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
    }

    public function rules()
    {
        return [
            'identify' => 'required|string|unique:staff,id',
            'name' => 'required|string|min:3|max:40',
            'gender' => [
                'required',
                Rule::in(collect($this->genders)->pluck('value')->toArray())
            ],
            'email' => 'required|email:dns|unique:users,email',
            'phone_number' => ['required', new PhoneNumber]
        ];
    }

    public function validationAttributes()
    {
        return [
            'identify' => __(':type Id', ['type' => __('Staff')]),
            'name' => __('Fullname'),
            'gender' => __('Gender'),
            'email' => __('Email'),
            'phone_number' => __('Phone Number')
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function render()
    {
        return view('pages.staff.create');
    }

    public function store()
    {
        $this->validate();
        $this->isLoading = true;
        DB::beginTransaction();
        try {
            $newUser = [
                'id' => $this->identify,
                'name' => $this->name,
                'gender' => $this->gender,
                'phone_number' => $this->phone_number,
            ];

            $newUser = Staff::create($newUser);

            $user = User::create(
                [
                    'password' => bcrypt($this->identify),
                    'email' => $this->email
                ]
            );

            $userType = new UserType(['user_id' => $user->id]);

            $newUser->userable()->save($userType);

            WaSender::dispatch(
                WaHelper::getTemplate('create_user', [
                    'id' => $this->identify,
                    'name' => $this->name,
                    'password' => $this->identify,
                    'type' => __('Staff')
                ]),
                $this->phone_number
            );

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('refreshStaff');
            $this->dispatch('setSearch', $this->name);
            $this->dispatch('toggle-create-staff-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Staff')])]);
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

    public function refresh()
    {
        $this->reset('identify', 'name', 'email', 'gender', 'phone_number');
        $this->resetValidation();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->resetValidation();
    }
}
