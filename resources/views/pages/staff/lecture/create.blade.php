<div>
    <x-modal.body>
        <x-form.select-with-search :loading="$isLoading" error="{{ $errors->first('room') }}" wire:model.blur='room' block
            :label="__('Room')" :items="$rooms" required />
        <x-form.select-with-search :loading="$isLoading" error="{{ $errors->first('course') }}" wire:model.blur='course' block
            :label="__('Course')" :items="$courses" required />
        <x-form.select-with-search :loading="$isLoading" error="{{ $errors->first('lecturer') }}" wire:model.blur='lecturer'
            block :label="__('Lecturer')" :items="$lecturers" required />
        <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
            <x-form.select-with-search class="flex-1" :loading="$isLoading" error="{{ $errors->first('day') }}"
                wire:model.blur='day' block :label="__('Day')" :items="$days" required />
            <x-form.input :loading="$isLoading" :label="__('Limit')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Limit'))])" type='number'
                error="{{ $errors->first('limit') }}" wire:model.blur='limit' required />
        </div>
        <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
            <x-form.input class="flex-1" :loading="$isLoading" :label="__('Start Time')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Start Time'))])" type='text'
                error="{{ $errors->first('start_time') }}" wire:model.blur='start_time' info="Format: 08:00" required />
            <x-form.input class="flex-1" :loading="$isLoading" :label="__('End Time')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('End Time'))])" type='text'
                error="{{ $errors->first('end_time') }}" wire:model.blur='end_time' info="Format: 10:00" required />
        </div>
    </x-modal.body>
    <x-modal.footer>
        <x-button wire:click="refresh" :loading="$isLoading">
            {{ __('Reset') }}
        </x-button>

        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
