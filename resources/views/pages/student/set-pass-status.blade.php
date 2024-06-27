<div>
    <x-modal.body>
        @if (!$isLoading)
            @if ($student)
                <div class="space-y-3 text-gray-700 sm:space-y-4 dark:text-gray-100">
                    <div class="flex items-start">
                        <div class="w-44">
                            {{ __('NPM') }}
                        </div>
                        <div class="flex-1 font-semibold">
                            {{ $student->id }}
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-44">
                            {{ __('Nama Lengkap') }}
                        </div>
                        <div class="flex-1 font-semibold">
                            {{ $student->name }}
                        </div>
                    </div>
                    <x-form.input block class="flex-1" :loading="$isLoading" :label="__('Grade Point Average (GPA)')" type='number'
                        error="{{ $errors->first('gpa') }}" wire:model.blur='gpa' required />
                    <div>
                        <div class="flex items-center overflow-hidden shadow rounded-xl">
                            @foreach ($passTypes as $idx => $item)
                                <label for="type-{{ $idx + 1 }}"
                                    class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                                    <input name="type" wire:loading.attr='disabled' wire:model.blur='passType'
                                        class="hidden peer/type" id="type-{{ $idx + 1 }}" type="radio"
                                        value="{{ $item }}" @disabled($isLoading) />
                                    <div
                                        class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                        {{ __(Str::headline($item)) }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('passType')
                            <div class="mt-1 text-red-700">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            @else
                <x-no-data />
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" wire:click='save' :loading="$isLoading">
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
