<?php

namespace App\Livewire\Student;

use App\Jobs\WaSender;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Models\Register;
use App\Rules\PhoneNumber;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use LivewireAlert;

    protected $listeners = ['clearModal'];

    public string $npm;
    public string $name;
    public string $email;
    public string $stamp;
    public string $phoneNumber;

    public bool $isLoading = false;

    public function render()
    {
        return view('pages.student.create');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function rules()
    {
        return [
            'npm' => 'required|string|size:9|unique:registers,student_id|unique:students,id',
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|email:dns|unique:users,email',
            'stamp' => 'required|numeric|digits:4',
            'phoneNumber' => ['required', new PhoneNumber]
        ];
    }

    public function validationAttributes()
    {
        return [
            'npm' => 'NPM',
            'name' => __('Fullname'),
            'email' => __('Email'),
            'stamp' => __('Stamp'),
            'phoneNumber' => __('Phone Number'),
        ];
    }

    public function refresh()
    {
        $this->reset();
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $token = Str::random(8);

            Register::create([
                'student_id' => $this->npm,
                'name' => $this->name,
                'email' => $this->email,
                'stamp' => $this->stamp,
                'phone_number' => $this->phoneNumber,
                'expired_at' => \Carbon\Carbon::now()->addDays(7),
                'token' => $token,
            ]);

            WaSender::dispatch(
                WaHelper::getTemplate('student_registration', [
                    'npm' => $this->npm,
                    'name' => $this->name,
                    'token' => $token,
                ]),
                $this->phoneNumber
            );

            $this->isLoading = false;
            DB::commit();
            $this->dispatch('refreshStudents');
            $this->dispatch('setSearch', $this->name);
            $this->dispatch('setViewActive', 'student_registration');
            $this->dispatch('toggle-create-student-modal');
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Student')])]);
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
