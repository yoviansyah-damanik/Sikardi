<div class="w-full max-w-[520px] mx-auto sm:mt-24 flex justify-center flex-col space-y-4 lg:space-y-6">
    <div
        class="relative px-6 py-6 bg-transparent sm:shadow-sm sm:bg-white/30 sm:dark:bg-slate-700/30 sm:rounded-xl sm:py-9 sm:px-9 sm:backdrop-blur-xl min-h-48">
        <form wire:submit='login' class="space-y-3 sm:space-y-6">
            <div>
                <div class="flex items-center overflow-hidden shadow rounded-xl">
                    @foreach ($types as $idx => $type)
                        <label for="type-{{ $idx + 1 }}"
                            class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                            <input name="type" wire:loading.attr='disabled' wire:model.blur='type'
                                class="hidden peer/type" wire:change='checkLoginType' id="type-{{ $idx + 1 }}"
                                type="radio" value="{{ $type }}" />
                            <div
                                class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                {{ __(Str::ucfirst($type)) }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('type')
                    <div class="mt-1 text-red-700">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <x-form.input :loading="$isLoading" :label="$loginType" block :placeholder="__('Entry :entry', ['entry' => __(Str::ucfirst($loginType))])" type='text'
                error="{{ $errors->first('loginId') }}" wire:model.blur='loginId' required />
            <x-form.input :loading="$isLoading" :label="__('Password')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Password'))])" type='password'
                wire:model.blur='password' error="{{ $errors->first('password') }}" required />

            <div class="flex items-center justify-between !mt-7">
                <x-form.checkbox :loading="$isLoading" :label="__('Remember Me')" error="{{ $errors->first('rememberMe') }}"
                    wire:model.blur='rememberMe' />
                <a class="text-gray-700 dark:text-gray-100" href="{{ route('register') }}" wire:navigate>
                    {{ __('Don\'t have an account yet?') }}
                </a>
            </div>

            <x-button :loading="$isLoading" wire:target="login, username, password" color="primary" type="submit" block
                radius="rounded-full" base="!mt-8 lg:!mt-10">
                Login
            </x-button>
        </form>
    </div>
</div>
