<div class="w-full max-w-xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
    <div class="mb-6 font-semibold text-scampi-700">
        {{ __('Data :data', ['data' => __('Account')]) }}
    </div>
    <div class="mb-6 space-y-3 sm:space-y-4">
        <x-form.input :loading="$isLoading" :label="__('Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Fullname'))])" type='text'
            error="{{ $errors->first('name') }}" wire:model.blur='name' required />
        <x-form.input :loading="$isLoading" :label="__('Phone Number')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Phone Number'))])" type='number'
            error="{{ $errors->first('phoneNumber') }}" wire:model.blur='phoneNumber' info="Format: 08XXXXXXXXXX"
            required />
        <x-form.radio :label="__('Gender')" error="{{ $errors->first('gender') }}" :items="$genders" inline
            wire:model.blur='gender' />
    </div>
    <x-button wire:click="save" :loading="$isLoading" block color="primary">
        {{ __('Save') }}
    </x-button>
</div>
