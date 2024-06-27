<x-content>
    <x-content.title :title="__('Account')" :description="__('Manage your account.')" />

    <div class="flex flex-col items-start gap-6 sm:flex-row">
        <div class="w-full max-w-xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
            <div class="mb-6 font-semibold text-scampi-700">
                {{ __('Data :data', ['data' => __('User')]) }}
            </div>
            <div class="mb-6 space-y-3 sm:space-y-4">
                <x-form.input error="{{ $errors->first('email') }}" :loading="$isLoading" :label="__('Email')" block
                    type="email" wire:model.blur='email' />
                <x-form.input error="{{ $errors->first('confPassword') }}" :loading="$isLoading" :label="__('Confirmation Password')" block
                    type="password" wire:model.blur='confPassword' />
                <x-form.input error="{{ $errors->first('newPassword') }}" :loading="$isLoading" :label="__('New Password')" block
                    type="password" wire:model.blur='newPassword' />
                <x-form.input error="{{ $errors->first('rePassword') }}" :loading="$isLoading" :label="__('Re-Password')" block
                    type="password" wire:model.blur='rePassword' />
            </div>
            <x-button wire:click="save" :loading="$isLoading" block color="primary">
                {{ __('Save') }}
            </x-button>
        </div>
        @if (auth()->user()->role == 'lecturer')
            <livewire:account.lecturer />
        @elseif(auth()->user()->role == 'staff')
            <livewire:account.staff />
        @elseif(auth()->user()->role == 'student')
            <livewire:account.student />
        @endif
    </div>
</x-content>
