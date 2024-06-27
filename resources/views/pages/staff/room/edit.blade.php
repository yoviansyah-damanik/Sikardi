<div>
    <x-modal.body>
        <x-form.input :loading="$isLoading" :label="__(':code Code', ['code' => __('Room')])" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__(':code Code', ['code' => __('Room')]))])" type='text'
            error="{{ $errors->first('code') }}" wire:model.blur='code' required />
        <x-form.input :loading="$isLoading" :label="__(':name Name', ['name' => __('Room')])" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__(':name Name', ['name' => __('Room')]))])" type='text'
            error="{{ $errors->first('name') }}" wire:model.blur='name' required />
        <x-form.textarea :loading="$isLoading" rows="4" :label="__('Description')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Description'))])"
            error="{{ $errors->first('description') }}" limit=200 wire:model.blur='description' required />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
