<div>
    <x-modal.body>
        @if (!$isLoading)
            <div>
                {{ __('Are you sure you will forget the password for the account below?') }}
            </div>
            <div class="space-y-1">
                <div class="flex">
                    <div class="w-48">{{ 'NPM/NIDN/' . __(':type Id', ['type' => __('Staff')]) }}</div>
                    <div class="flex-1 font-semibold">{{ $user->data->id }}</div>
                </div>
                <div class="flex">
                    <div class="w-48">{{ __('Fullname') }}</div>
                    <div class="flex-1 font-semibold">{{ $user->data->name }}</div>
                </div>
            </div>

            @if ($result)
                <hr class="my-3" />
                <div class="flex">
                    <div class="w-48">{{ __('New Password') }}</div>
                    <div class="flex-1 font-semibold">{{ $result['new_password'] }}</div>
                </div>
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='submit' :loading="$isLoading">
            {{ __('Submit') }}
        </x-button>
    </x-modal.footer>
</div>
