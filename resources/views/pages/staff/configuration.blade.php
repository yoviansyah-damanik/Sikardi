<x-content>
    <x-content.title :title="__('Configurations')" :description="__('Manage system configuration.')" />

    <div class="w-full max-w-4xl p-6 bg-white shadow dark:bg-slate-800 rounded-xl sm:p-8">
        <div class="mb-6 font-semibold text-scampi-700">
            {{ __('Adjust System Configuration') }}
        </div>
        <div class="mb-6 space-y-3 sm:space-y-4">
            <x-form.input :label="__('App Name')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('App Name'))])" type='text'
                error="{{ $errors->first('app_name') }}" wire:model.blur='app_name' />
            <x-form.input :label="__('App Fullname')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('App Fullname'))])" type='text'
                error="{{ $errors->first('app_fullname') }}" wire:model.blur='app_fullname' />
            <x-form.input :label="__('Name of Department Head')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Name of Department Head'))])" type='text'
                error="{{ $errors->first('name_of_department_head') }}" wire:model.blur='name_of_department_head' />
            <x-form.input :label="__('NIDN of Department Head')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('NIDN of Department Head'))])" type='text'
                error="{{ $errors->first('nidn_of_department_head') }}" wire:model.blur='nidn_of_department_head' />
            <x-form.input :label="__('Odd Semester')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Odd Semester'))])" type='text'
                error="{{ $errors->first('odd_semester') }}" wire:model.blur='odd_semester' :info="__('You will enter an odd semester if you enter the date above. Format: (Date)-(Month)')" />
            <x-form.input :label="__('Even Semester')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Even Semester'))])" type='text'
                error="{{ $errors->first('even_semester') }}" wire:model.blur='even_semester' :info="__('You will enter an even semester if you enter the date above. Format: (Date)-(Month)')" />
            <x-form.input :label="__('CC Limit')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('CC Limit'))])" type='text'
                error="{{ $errors->first('cc_limit') }}" wire:model.blur='cc_limit' :info="__('Limits on the number of credits that students can take each semester.')" />
            <div>
                <label :for="id"
                    class="block mb-3 text-base font-medium text-primary-700 dark:text-slate-100 "
                    for="app_name-2">{{ __('Open CSS Filling') }}</label>
                <div class="flex items-center overflow-hidden shadow rounded-xl">
                    @foreach ($isOpenTypes as $idx => $isOpenType)
                        <label for="type-{{ $idx + 1 }}"
                            class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                            <input name="type" wire:loading.attr='disabled' wire:model.live='is_open'
                                class="hidden peer/type" id="type-{{ $idx + 1 }}" type="radio"
                                value="{{ $isOpenType['value'] }}" />
                            <div
                                class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                {{ $isOpenType['title'] }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('type')
                    <div class="mt-1 text-red-700">
                        {{ $message }}
                    </div>
                @else
                    <div class="mt-1 text-sm text-gray-700 dark:text-gray-100 ms-4">
                        {{ __('Open KRS Filling forces the system to open a KRS filling schedule without involving the predetermined KRS filling time.') }}
                    </div>
                @enderror
            </div>
            <x-form.input :label="__('Start Date')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Start Date'))])" type='date'
                error="{{ $errors->first('start_date') }}" :loading="$is_open" wire:model.blur='start_date'
                :info="__('Filling Out Date is not required when Open Filling Out KRS is enabled.')" />
            <x-form.input :label="__('End Date')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('End Date'))])" type='date'
                error="{{ $errors->first('end_date') }}" :loading="$is_open" wire:model.blur='end_date'
                :info="__('Filling Out Date is not required when Open Filling Out KRS is enabled.')" />
        </div>
    </div>

</x-content>
