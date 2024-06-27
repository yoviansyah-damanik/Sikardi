<div>
    <x-modal.body>
        @if (!$isLoading)
            {{ __('Are you sure you want to delete this :item?', ['item' => Str::lower(__('Registration'))]) }}
        @else
            <x-loading />
        @endif
    </x-modal.body>
    <x-modal.footer>
        <x-button color="red" wire:click='destroy' :loading="$isLoading">
            {{ __('Delete') }}
        </x-button>
    </x-modal.footer>
</div>
