<div class="w-full max-w-[520px] mx-auto flex justify-center flex-col space-y-4 lg:space-y-6">
    <div class="px-6 sm:px-0">
        <div id="steps" class="relative mb-6 space-y-4">
            <div class="text-lg font-semibold text-center text-scampi-700 dark:text-scampi-300">
                {{ __(':data Steps', ['data' => __('Register')]) }}
            </div>
            <div class="flex justify-between pt-6">
                <div class="relative flex-1 h-10">
                    <div @class([
                        'absolute z-20 -translate-x-1/2 rounded-full bg-scampi-300 size-4 left-1/2',
                        '!bg-scampi-700' => in_array($step, [1, 2, 3, 4]),
                    ])></div>
                    <div @class([
                        'absolute z-10 w-full h-2 mt-1 translate-x-1/2 bg-scampi-300',
                        '!bg-scampi-700' => in_array($step, [1, 2, 3, 4]),
                        'animate-pulse' => $step == 1,
                    ])></div>
                    <div @class([
                        'mt-5 text-center text-gray-700 dark:text-gray-100 px-1',
                        'text-scampi-700 dark:text-scampi-300' => $step == 1,
                    ])>
                        {{ __('Token') }}
                    </div>
                </div>
                <div class="relative flex-1 h-10">
                    <div @class([
                        'absolute z-20 -translate-x-1/2 rounded-full bg-scampi-300 size-4 left-1/2',
                        '!bg-scampi-700' => in_array($step, [2, 3, 4]),
                    ])></div>
                    <div @class([
                        'absolute z-10 w-full h-2 mt-1 translate-x-1/2 bg-scampi-300',
                        '!bg-scampi-700' => in_array($step, [2, 3, 4]),
                        'animate-pulse' => $step == 2,
                    ])></div>
                    <div @class([
                        'mt-5 text-center text-gray-700 dark:text-gray-100 px-1',
                        'text-scampi-700 dark:text-scampi-300' => $step == 2,
                    ])>
                        {{ __(':data Data', ['data' => __('Student')]) }}
                    </div>
                </div>
                <div class="relative flex-1 h-10">
                    <div @class([
                        'absolute z-20 -translate-x-1/2 rounded-full bg-scampi-300 size-4 left-1/2',
                        '!bg-scampi-700' => in_array($step, [3, 4]),
                    ])></div>
                    <div @class([
                        'absolute z-10 w-full h-2 mt-1 translate-x-1/2 bg-scampi-300',
                        '!bg-scampi-700' => in_array($step, [3, 4]),
                        'animate-pulse' => $step == 3,
                    ])></div>
                    <div @class([
                        'mt-5 text-center text-gray-700 dark:text-gray-100 px-1',
                        'text-scampi-700 dark:text-scampi-300' => $step == 3,
                    ])>
                        {{ __(':data Data', ['data' => __('User')]) }}
                    </div>
                </div>
                <div class="relative flex-1 h-10">
                    <div @class([
                        'absolute z-20 -translate-x-1/2 rounded-full bg-scampi-300 size-4 left-1/2',
                        '!bg-scampi-700' => $step == 4,
                    ])></div>
                    <div @class([
                        'mt-5 text-center text-gray-700 dark:text-gray-100 px-1',
                        'text-scampi-700 dark:text-scampi-300' => $step == 4,
                    ])>
                        {{ __('Finish') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($step)
        @if ($showAlert)
            <x-alert base="mb-0 mx-6 sm:mx-0" :type="$alert['type']">
                {{ $alert['message'] }}
            </x-alert>
        @endif
        <div
            class="relative flex-none max-w-full px-6 py-6 bg-transparent sm:shadow-sm sm:bg-white/30 dark:sm:bg-slate-800/60 sm:rounded-xl sm:py-9 sm:px-9 sm:backdrop-blur-xl">
            @if ($step == 1)
                <div id="step-1" class="space-y-3 sm:space-y-6">
                    <x-form.input loading="{{ $isLoading }}" label='NPM' block :placeholder="__('Entry :entry', ['entry' => 'NPM'])" type='text'
                        error="{{ $errors->first('npm') }}" wire:model.blur='npm' required />
                    <x-form.input loading="{{ $isLoading }}" label='Token' block :placeholder="__('Entry :entry', ['entry' => 'Token'])" type='text'
                        error="{{ $errors->first('token') }}" wire:model.blur='token' required />

                    <div class="flex items-center justify-between !mt-8">
                        <a class="text-gray-700 dark:text-gray-100" href="{{ route('login') }}" wire:navigate>
                            {{ __('Already have an account?') }}
                        </a>
                        <x-button base="inline-flex gap-3 items-center px-6" icon="i-ph-arrow-right"
                            iconPosition="right" loading="{{ $isLoading }}" color="primary" type="button"
                            wire:click='check' radius="rounded-full">
                            {{ __('Next') }}
                        </x-button>
                    </div>
                </div>
            @elseif($step == 2)
                <div id="step-2" class="space-y-3 sm:space-y-6">
                    <div class="grid grid-cols-12 gap-x-6">
                        <div class="col-span-7">
                            <x-form.input loading="{{ $isLoading }}" :label="__('NPM')" block type='text'
                                error="{{ $errors->first('npm') }}" wire:model.blur='npm' disabled />
                        </div>
                        <div class="col-span-5">
                            <x-form.input loading="{{ $isLoading }}" :label="__('Stamp')" block type='text'
                                error="{{ $errors->first('stamp') }}" wire:model.blur='stamp' disabled />
                        </div>
                    </div>
                    <x-form.input loading="{{ $isLoading }}" :label="__('Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Fullname'))])"
                        type='text' error="{{ $errors->first('name') }}" wire:model.blur='name' required />
                    <x-form.input loading="{{ $isLoading }}" :label="__('Address')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Address'))])"
                        type='text' error="{{ $errors->first('address') }}" wire:model.blur='address' required />
                    <x-form.input loading="{{ $isLoading }}" :label="__('Place of Birth')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Place of Birth'))])"
                        type='text' error="{{ $errors->first('placeOfBirth') }}" wire:model.blur='placeOfBirth'
                        required />
                    <x-form.input loading="{{ $isLoading }}" :label="__('Phone Number')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Phone Number'))])"
                        type='text' error="{{ $errors->first('phoneNumber') }}" wire:model.blur='phoneNumber'
                        required />
                    <div class="grid grid-cols-2 gap-x-6">
                        <div class="col-span-1">
                            <x-form.input loading="{{ $isLoading }}"
                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" :label="__('Date of Birth')" block
                                :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Date of Birth'))])" type='date' error="{{ $errors->first('dateOfBirth') }}"
                                wire:model.blur='dateOfBirth' required />
                        </div>
                        <div class="col-span-1">
                            <x-form.radio error="{{ $errors->first('gender') }}" loading="{{ $isLoading }}"
                                :items="$genders" :label="__('Gender')" wire:model.blur='gender' required />
                        </div>
                    </div>

                    <div class="flex items-center justify-between !mt-8">
                        <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                            color="red" type="button" icon="i-ph-arrow-left" wire:click='back'
                            radius="rounded-full">
                            {{ __('Back') }}
                        </x-button>

                        <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                            icon="i-ph-arrow-right" iconPosition="right" color="primary" type="button"
                            radius="rounded-full" wire:click='check'>
                            {{ __('Next') }}
                        </x-button>
                    </div>
                </div>
            @elseif($step == 3)
                <div id="step-3" class="space-y-3 sm:space-y-6">
                    <x-form.input loading="{{ $isLoading }}" :label="__('Email')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Email'))])"
                        type='text' error="{{ $errors->first('email') }}" wire:model.blur='email' required />
                    <x-form.input loading="{{ $isLoading }}" :label="__('Password')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Password'))])"
                        type='password' error="{{ $errors->first('password') }}" :info="__(
                            'The :attribute consists of a minimum of 8 characters consisting of 1 symbol, 1 small letter, 1 large letter, and 1 number.',
                            ['attribute' => __('Password')],
                        )"
                        wire:model.blur='password' required />
                    <x-form.input loading="{{ $isLoading }}" :label="__('Re-Password')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Re-Password'))])"
                        type='password' error="{{ $errors->first('rePassword') }}" wire:model.blur='rePassword'
                        required />

                    <div class="flex items-center justify-between !mt-8">
                        <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                            icon="i-ph-arrow-left" color="red" type="button" wire:click='back'
                            radius="rounded-full">
                            {{ __('Back') }}
                        </x-button>

                        <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                            icon="i-ph-arrow-right" iconPosition="right" color="primary" type="button"
                            radius="rounded-full" wire:click='check'>
                            {{ __('Next') }}
                        </x-button>
                    </div>
                </div>
            @elseif($step == 4)
                <div id="step-4" class="space-y-3 sm:space-y-6">
                    @if ($isComplete)
                        <div class="text-gray-700 dark:text-gray-100">
                            {{ __('Please check your data again before registering.') }}
                        </div>
                        <div class="mt-3 text-gray-700 dark:text-gray-100">
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('NPM') }}
                                </div>
                                <div class="flex-1">
                                    {{ $npm }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Stamp') }}
                                </div>
                                <div class="flex-1">
                                    {{ $stamp }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Name') }}
                                </div>
                                <div class="flex-1">
                                    {{ $name }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Address') }}
                                </div>
                                <div class="flex-1">
                                    {{ $address }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Place of Birth') }}
                                </div>
                                <div class="flex-1">
                                    {{ $placeOfBirth }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Date of Birth') }}
                                </div>
                                <div class="flex-1">
                                    {{ \Carbon\Carbon::parse($dateOfBirth)->translatedFormat('d F Y') }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Phone Number') }}
                                </div>
                                <div class="flex-1">
                                    {{ $phoneNumber }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Email') }}
                                </div>
                                <div class="flex-1">
                                    {{ $email }}
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-36">
                                    {{ __('Password') }}
                                </div>
                                <div class="flex-1">
                                    {{ Str::mask($password, '*', -(strlen($password) - 2), strlen($password) - 4) }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between !mt-8">
                            <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                                icon="i-ph-arrow-left" color="red" type="button" wire:click='back'
                                radius="rounded-full">
                                {{ __('Back') }}
                            </x-button>

                            <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                                icon="i-ph-check" color="primary" type="button" radius="rounded-full"
                                wire:click='check'>
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    @else
                        <div class="text-gray-700 dark:text-gray-100">
                            {{ __('Your registration process cannot be completed. Some of the following attributes have not been filled in correctly. Please repeat your registration and make sure you have entered your data correctly.') }}
                            <div class="mt-3">
                                {{ join(', ', $incompleteField) }}
                            </div>
                        </div>
                        <div class="flex items-center justify-start !mt-8">
                            <x-button base="inline-flex gap-3 items-center px-6" loading="{{ $isLoading }}"
                                color="red" type="button" wire:click='resetStep' radius="rounded-full">
                                <span class="i-solar-alt-arrow-left-bold-duotone"></span>
                                {{ __('Reset') }}
                            </x-button>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @else
        <x-alert type="success" :closeButton="false">
            {{ __('Successfully registered an account. Please go to the login page to continue.') }}
            <div class="mt-3">
                <x-button size="sm" color="green" :href="route('login')">
                    {{ __('Go to Login Page') }}
                </x-button>
            </div>
        </x-alert>
    @endif
</div>
