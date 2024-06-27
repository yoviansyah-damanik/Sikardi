<div>
    <x-modal.body>
        <div class="mb-6 space-y-3 sm:space-y-4">
            <x-form.input :loading="$isLoading" label="NIDN" block :placeholder="__('Entry :entry', ['entry' => 'NIDN'])" type='text'
                error="{{ $errors->first('identify') }}" wire:model.blur='identify' :info="__('NIDN for Lecturers and Staff ID for Staff.')" required />
            <x-form.input :loading="$isLoading" :label="__('Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Fullname'))])" type='text'
                error="{{ $errors->first('name') }}" wire:model.blur='name' required />
            <x-form.input :loading="$isLoading" :label="__('Email')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Email'))])" type='text'
                error="{{ $errors->first('email') }}" wire:model.blur='email' required />
            <x-form.input :loading="$isLoading" :label="__('Phone Number')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Phone Number'))])" type='number'
                error="{{ $errors->first('phone_number') }}" wire:model.blur='phone_number' info="Format: 08XXXXXXXXXX"
                required />
            <x-form.radio :label="__('Gender')" error="{{ $errors->first('gender') }}" :items="$genders" inline
                wire:model.blur='gender' />
            <x-alert type="info" :closeButton="false">
                {{ __('The new user password is the same as the registered ID.') }}
            </x-alert>
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
