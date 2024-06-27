<x-content>
    <x-content.title :title="__('Report')" :description="__('Download the report you need.')" />

    <div class="w-full max-w-xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
        <div class="mb-6 font-semibold text-scampi-700">
            {{ __(':type Type', ['type' => __('Report')]) }}
        </div>
        <div class="mb-6 space-y-3 sm:space-y-4">
            <x-form.select wire:change='setFilter' block :label="__('Group')" :items="$typesGroup"
                wire:model.live='typeGroup' />
            <x-form.select wire:change='setFilter' block :label="__('Type')" :items="$types" wire:model.live='type' />
            {{-- <x-form.select block :label="__('Year')" :items="range(2024, date('Y'))" wire:model.live='year' /> --}}
            {{-- <x-form.select block :label="__('Month')" :items="$months" wire:model.live='month' /> --}}
        </div>
        <x-button wire:click='print' color="primary" block icon="i-ph-download">
            {{ __('Download') }}
        </x-button>
    </div>

</x-content>
