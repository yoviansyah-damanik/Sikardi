<?php

namespace App\Livewire\Auth;

use Carbon\Carbon;
use App\Jobs\WaSender;
use App\Models\Student;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Rules\PhoneNumber;
use App\Enums\GenderChoice;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Register extends Component
{
    use LivewireAlert;

    #[Layout('layouts.auth')]

    public ?string $npm;
    public ?string $token;
    public ?string $name;
    public ?string $email;
    public ?string $stamp;
    public ?string $address;
    public ?string $placeOfBirth;
    public ?string $dateOfBirth;
    public ?string $gender;
    public ?string $password;
    public ?string $rePassword;
    public ?string $phoneNumber;
    public string $thisDay;

    public array $genders;

    public ?array $alert;

    public ?int $step = 1;
    public int $stepMin = 1;
    public int $stepMax = 4;

    public bool $isLoading = false;
    public bool $isValid = false;
    public bool $showAlert = false;
    public bool $isComplete = true;
    public ?array $incompleteField;

    public function mount()
    {
        $this->thisDay = Carbon::now();
        $this->checkAlert();
        $this->genders = collect(GenderChoice::cases())
            ->map(fn ($gender) => ['value' => $gender->name, 'label' => $gender->value])
            ->toArray();
    }

    public function render()
    {
        return view('pages.auth.register')
            ->title(__('Register'));
    }

    public function validationAttributes()
    {
        return [
            'npm' => 'NPM',
            'name' => __('Fullname'),
            'placeOfBirth' => __('Place of Birth'),
            'dateOfBirth' => __('Date of Birth'),
            'gender' => __('Gender'),
            'password' => __('Password'),
            'rePassword' => __('Re-Password'),
            'phoneNumber' => __('Phone Number'),
            'address' => __('Address'),
        ];
    }

    public function messages()
    {
        return [
            'dateOfBirth.before_or_equal' => __('The :attribute field must be a date before or equal to :date.', ['date' => Carbon::parse($this->thisDay)->translatedFormat('d/m/Y')]),
        ];
    }

    public function rules()
    {
        return [
            'npm' => 'required|string|size:9',
            'token' => 'required|string|size:8',
            'name' => 'required|string|min:3|max:40',
            'address' => 'required|string|min:3|max:200',
            'placeOfBirth' => 'required|string|min:3|max:40',
            'dateOfBirth' => 'required|date|beforeOrEqual:' . $this->thisDay,
            'gender' => [
                'required',
                Rule::in(GenderChoice::names())
            ],
            'email' => 'required|email:dns|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'rePassword' => 'required|same:password',
            'phoneNumber' => ['required', new PhoneNumber]
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function refresh()
    {
        $this->reset();
        $this->isLoading = false;
    }
    public function validationStep()
    {
        if ($this->step < $this->stepMax) {
            $step1 = ['npm', 'token'];
            $step2 = ['name', 'placeOfBirth', 'dateOfBirth', 'gender', 'phoneNumber'];
            $step3 = ['email', 'password', 'rePassword'];

            $rules = collect($this->rules())
                ->filter(function ($item, $key) use ($step1, $step2, $step3) {
                    return in_array($key, ${'step' . $this->step});
                })
                ->toArray();

            $this->validate($rules);
            $haystack = [];
            foreach (range(1, $this->step) as $step)
                $haystack[] = ${'step' . $step};

            $this->isComplete(collect($haystack)->collapse()->toArray());
        }
    }

    public function isComplete(array $haystack)
    {
        $this->isComplete = true;
        $this->incompleteField = [];

        foreach ($haystack as $hay)
            if (empty($this->{$hay})) {
                $this->isComplete = false;
                $this->incompleteField[] = __(Str::of($hay)->snake()->headline()->value);
            }
    }

    public function check()
    {
        $this->validationStep();
        $this->isLoading = true;
        try {
            if ($this->step == 1) {
                $registered = \App\Models\Register::where([
                    'student_id' => $this->npm,
                    'token' => $this->token,
                ])->first();

                if ($registered) {
                    if (now() > $registered->expired_at) {
                        $this->alert('warning', __('The token you have has expired. Please contact the administrator.'));
                    } else {
                        $this->name = $registered->name;
                        $this->email = $registered->email;
                        $this->stamp = $registered->stamp;
                        $this->phoneNumber = $registered->phone_number;
                        $this->next();
                        // $this->checkAlert();
                    }
                } else {
                    $this->alert('warning', __('The data you entered was not detected in the system.'));
                }
                $this->isLoading = false;
            } elseif ($this->step == 2) {
                $this->next();
                $this->checkAlert();
                $this->isLoading = false;
            } elseif ($this->step == 3) {
                $this->next();
                $this->checkAlert();
                $this->isLoading = false;
            } elseif ($this->step == 4) {
                DB::transaction(function () {
                    $student = Student::create([
                        'id' => $this->npm,
                        'name' => $this->name,
                        'place_of_birth' => $this->placeOfBirth,
                        'date_of_birth' => $this->dateOfBirth,
                        'address' => $this->address,
                        'stamp' => $this->stamp,
                        'phone_number' => $this->phoneNumber,
                    ]);

                    $user = $student->user()->create([
                        'email' => $this->email,
                        'password' => bcrypt($this->password)
                    ]);

                    $student->userable()->create([
                        'user_id' => $user->id,
                    ]);

                    \App\Models\Register::where('student_id', $this->npm)->delete();

                    WaSender::dispatch(WaHelper::getTemplate('successful_registration', [
                        'npm' => $this->npm,
                        'password' => $this->password,
                        'name' => $this->name
                    ]), $this->phoneNumber);

                    WaSender::dispatch(WaHelper::getTemplate('successful_registration_staff', [
                        'npm' => $this->npm,
                        'name' => $this->name
                    ]), \App\Models\Staff::all()->pluck('phone_number')->toArray());

                    DB::commit();
                    $this->isLoading = true;
                    $this->step = null;
                });
            } else {
                $this->alert('warning', __('There is no function for the current step.'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->isLoading = false;
            $this->alert('warning', __('Something went wrong.'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->isLoading = false;
            $this->alert('warning', __('Something went wrong.'), ['text' => $e->getMessage()]);
        }
    }

    public function register()
    {
        $this->validate();
    }

    public function next()
    {
        if ($this->step < $this->stepMax) $this->step++;
        else $this->step = $this->stepMax;
        $this->checkAlert();
    }

    public function back()
    {
        if ($this->step > $this->stepMin) $this->step--;
        else $this->step = $this->stepMin;
        $this->checkAlert();
    }

    public function resetStep()
    {
        $this->step = $this->stepMin;
        $this->checkAlert();
    }

    public function checkAlert()
    {
        if ($this->step === 1) {
            $this->showAlert = true;
            $this->alert = [
                'type' => 'info',
                'message' => __('Enter the NPM and Token that you have.')
            ];
        } else if ($this->step === 2) {
            $this->showAlert = true;
            $this->alert = [
                'type' => 'info',
                'message' => __('Please enter your data correctly.')
            ];
        } else {
            $this->showAlert = false;
            $this->alert = [
                'type' => 'info',
                'message' => null
            ];
        }
    }
}
