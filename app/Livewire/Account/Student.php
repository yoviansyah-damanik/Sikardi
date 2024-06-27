<?php

namespace App\Livewire\Account;

use Carbon\Carbon;
use Livewire\Component;
use App\Rules\PhoneNumber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Student extends Component
{
    use LivewireAlert;

    public string $name;
    public string $gender;
    public string $address;
    public string $phoneNumber;
    public string $dateOfBirth;
    public string $placeOfBirth;
    public string $thisDay;

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
        $this->address = auth()->user()->data->address;
        $this->placeOfBirth = auth()->user()->data->place_of_birth;
        $this->dateOfBirth = \Carbon\Carbon::parse(auth()->user()->data->date_of_birth)->format('Y-m-d');
        $this->phoneNumber = auth()->user()->data->phone_number;
        $this->thisDay = Carbon::now();
    }

    public function render()
    {
        return view('pages.account.student');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:40',
            'gender' => [
                'required',
                Rule::in(collect($this->genders)->pluck('value')->toArray())
            ],
            'phoneNumber' => ['required', new PhoneNumber],
            'address' => 'required|string|min:3|max:200',
            'placeOfBirth' => 'required|string|min:3|max:40',
            'dateOfBirth' => 'required|date|beforeOrEqual:' . $this->thisDay,
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => __('Fullname'),
            'gender' => __('Gender'),
            'phoneNumber' => __('Phone Number'),
            'address' => __('Address'),
            'placeOfBirth' => __('Place of Birth'),
            'dateOfBirth' => __('Date of Birth'),
        ];
    }

    public function messages()
    {
        return [
            'dateOfBirth.before_or_equal' => __('The :attribute field must be a date before or equal to :date.', ['date' => Carbon::parse($this->thisDay)->translatedFormat('d/m/Y')]),
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
                'address' => $this->address,
                'place_of_birth' => $this->placeOfBirth,
                'date_of_birth' => $this->dateOfBirth,
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
