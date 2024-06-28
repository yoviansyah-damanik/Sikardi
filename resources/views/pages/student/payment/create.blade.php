<div>
    <x-modal.body>
        <x-form.input :loading="true" :label="__('Semester')" block type='text'
            value="{{ auth()->user()->data->semester }}" />
        <x-form.file :loading="$isLoading" accept="application/pdf" :label="__('Proof of Payment')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Proof of Payment'))])"
            error="{{ $errors->first('file') }}" wire:model.blur='file' required :info="__('PDF Only') .
                ' | ' .
                __('The :attribute field must not be greater than :max kilobytes.', [
                    'Attribute' => __('File'),
                    'max' => 2 * 1024,
                ])" />
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
