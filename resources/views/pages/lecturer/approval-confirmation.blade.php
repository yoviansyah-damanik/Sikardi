<div>
    <x-modal.body>
        <div>
            <div class="flex items-center overflow-hidden shadow rounded-xl">
                @foreach ($statusTypes as $idx => $type)
                    <label for="type-{{ $idx + 1 }}"
                        class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                        <input name="type" wire:loading.attr='disabled' wire:model.blur='statusType'
                            class="hidden peer/type" id="type-{{ $idx + 1 }}" type="radio"
                            @disabled($isLoading) value="{{ $type }}" />
                        <div
                            class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                            {{ __(Str::ucfirst($type)) }}
                        </div>
                    </label>
                @endforeach
            </div>
            @error('statusType')
                <div class="mt-1 text-red-700">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <x-form.textarea rows="4" :loading="$isLoading" :label="__('Message')" block :placeholder="__('Entry :entry', ['entry' => Str::lower(__('Message'))])"
            error="{{ $errors->first('message') }}" limit=200 wire:model.blur='message' required />
    </x-modal.body>
    <x-modal.footer>
        <x-button color="primary" :loading="$isLoading" wire:click='save'>
            {{ __('Save') }}
        </x-button>
    </x-modal.footer>
</div>
