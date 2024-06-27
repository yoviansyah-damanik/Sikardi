<div>
    <x-modal.body>
        <div class="mb-6 space-y-3 sm:space-y-4">
            <x-form.input :loading="$isLoading" :label="__('NPM')" block :placeholder="__('Entry :entry', ['entry' => __('NPM')])" type='text'
                error="{{ $errors->first('npm') }}" wire:model.blur='npm' required />
            <x-form.input :loading="$isLoading" :label="__('Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Fullname'))])" type='text'
                error="{{ $errors->first('name') }}" wire:model.blur='name' required />
            <x-form.input :loading="$isLoading" :label="__('Stamp')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Stamp'))])" type='number'
                error="{{ $errors->first('stamp') }}" wire:model.blur='stamp' required />
            <x-form.input :loading="$isLoading" :label="__('Email')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Email'))])" type='text'
                error="{{ $errors->first('email') }}" wire:model.blur='email' required />
            <x-form.input :loading="$isLoading" :label="__('Phone Number')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Phone Number'))])" type='number'
                error="{{ $errors->first('phoneNumber') }}" wire:model.blur='phoneNumber' info="Format: 08XXXXXXXXXX"
                required />
        </div>
    </x-modal.body>
    <x-modal.footer>
        <x-button wire:click="refresh" :loading="$isLoading">
            {{ __('Reset') }}
        </x-button>
        <x-button color="primary" wire:click='store' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
