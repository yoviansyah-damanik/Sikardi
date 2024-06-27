<?php

namespace App\Livewire\Auth;

use App\Models\Lecturer;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;
    #[Layout('layouts.auth')]

    public string $loginId;
    public string $loginType;
    public string $password;

    public bool $rememberMe = false;

    public array $types = ['student', 'lecturer', 'staff'];
    public string $type;

    public bool $isLoading = false;

    public string $errorMessages;

    public function mount()
    {
        $this->type  = $this->types[0];
        $this->checkLoginType();
    }

    public function checkLoginType()
    {
        if ($this->type == 'student') $this->loginType = __('NPM');
        elseif ($this->type == 'lecturer') $this->loginType = __('NIDN');
        else $this->loginType = __(':type Id', ['type' => __('Staff')]);
    }

    public function render()
    {
        return view('pages.auth.login')
            ->title(__('Login'));
    }

    public function rules()
    {
        return [
            'loginId' => 'required|string',
            'password' => 'required|string',
            'rememberMe' => 'nullable',
            'type' => ['required', Rule::in($this->types)]
        ];
    }

    public function validationAttributes()
    {
        return [
            'loginId' => $this->loginType,
            'password' => __('Password'),
            'rememberMe' => __('Remember Me'),
            'type' => __('Type')
        ];
    }

    public function login()
    {
        $this->validate();
        try {
            $this->isLoading = true;

            $loginId = $this->loginId;
            $password = $this->password;

            if ($this->type == 'student') $user = Student::find($loginId);
            if ($this->type == 'lecturer') $user = Lecturer::find($loginId);
            if ($this->type == 'staff') $user = Staff::find($loginId);

            $user = $user?->user;

            if ($user) {
                if (Hash::check($password, $user->password)) {
                    if ($user->is_suspended) {
                        $this->alert('error', __('Your account has been suspended. Please contact Study Program Staff for further information.'));
                        $this->isLoading = false;
                        return;
                    }

                    $user->last_login_at = Carbon::now();
                    $user->save();
                    Auth::login($user, $this->rememberMe === true);
                    return $this->redirectIntended(route('home'), false);
                }
            }

            $this->isLoading = false;
            $this->alert('warning', __('No credentials found.'));
        } catch (\Exception $e) {
            $this->isLoading = false;
            $this->alert('warning', $e->getMessage());
        } catch (\Throwable $e) {
            $this->isLoading = false;
            $this->alert('warning', $e->getMessage());
        }
    }
}
