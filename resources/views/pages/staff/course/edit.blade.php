<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__(':code Code', ['code' => __('Course')])" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__(':code Code', ['code' => __('Course')]))])" type='text'
            error="{{ $errors->first('code') }}" wire:model.blur='code' required />
        <x-form.input :loading="$isLoading" :label="__(':name Name', ['name' => __('Course')])" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__(':name Name', ['name' => __('Course')]))])" type='text'
            error="{{ $errors->first('name') }}" wire:model.blur='name' required />
        <div class="flex flex-col gap-3 sm:flex-row sm:gap-4">
            <x-form.select class="flex-1" :loading="$isLoading" :items="$semesters" :label="__('Semester')" block
                error="{{ $errors->first('semester') }}" wire:model.blur='semester' required />
            <x-form.input class="flex-1" :loading="$isLoading" :label="__('Course Credits (CC)')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Course Credits (CC)'))])" type='number'
                error="{{ $errors->first('credit') }}" wire:model.blur='credit' required />
        </div>
        <x-form.textarea :loading="$isLoading" rows="4" :label="__('Description')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Description'))])"
            error="{{ $errors->first('description') }}" limit=200 wire:model.blur='description' required />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
