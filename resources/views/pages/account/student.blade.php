<div class="w-full max-w-xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
    <div class="mb-6 font-semibold text-scampi-700">
        {{ __('Data :data', ['data' => __('Account')]) }}
    </div>
    <div class="mb-6 space-y-3 sm:space-y-4">
        <x-form.input :loading="$isLoading" :label="__('Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Fullname'))])" type='text'
            error="{{ $errors->first('name') }}" wire:model.blur='name' required />
        <x-form.input loading="{{ $isLoading }}" :label="__('Address')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Address'))])" type='text'
            error="{{ $errors->first('address') }}" wire:model.blur='address' required />
        <x-form.input :loading="$isLoading" :label="__('Phone Number')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Phone Number'))])" type='number'
            error="{{ $errors->first('phoneNumber') }}" wire:model.blur='phoneNumber' info="Format: 08XXXXXXXXXX"
            required />
        <x-form.input loading="{{ $isLoading }}" :label="__('Place of Birth')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Place of Birth'))])" type='text'
            error="{{ $errors->first('placeOfBirth') }}" wire:model.blur='placeOfBirth' required />
        <div class="grid grid-cols-2 gap-x-6">
            <div class="col-span-1">
                <x-form.input loading="{{ $isLoading }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                    :label="__('Date of Birth')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Date of Birth'))])" type='date'
                    error="{{ $errors->first('dateOfBirth') }}" wire:model.blur='dateOfBirth' required />
            </div>
            <div class="col-span-1">
                <x-form.radio error="{{ $errors->first('gender') }}" loading="{{ $isLoading }}" :items="$genders"
                    :label="__('Gender')" wire:model.blur='gender' required />
            </div>
        </div>
    </div>
    <x-button wire:click="save" :loading="$isLoading" block color="primary">
        {{ __('Save') }}
    </x-button>
</div>
