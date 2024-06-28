<div>
    <x-modal.body>
        @if (!$isLoading)
            @if (!empty($payment))
                <div class="flex items-center overflow-hidden shadow rounded-xl">
                    @foreach ($types as $idx => $item)
                        <label for="revision-{{ $idx + 1 }}"
                            class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                            <input name="revision" wire:loading.attr='disabled' wire:model.blur='type'
                                class="hidden peer/type" id="revision-{{ $idx + 1 }}" type="radio"
                                value="{{ $item }}" @disabled($isLoading) />
                            <div
                                class="w-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/type:text-gray-100 peer-checked/type:bg-primary-700 peer-checked/type:opacity-100 ">
                                {{ __(Str::headline($item)) }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('type')
                    <div class="mt-1 text-red-700">
                        {{ $message }}
                    </div>
                @enderror
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('NPM') }}
                    </div>
                    <div class="flex-1">
                        {{ $payment->student->id }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Name') }}
                    </div>
                    <div class="flex-1">
                        {{ $payment->student->name }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Semester') }}
                    </div>
                    <div class="flex-1">
                        {{ $payment->semester }}
                    </div>
                </div>
                <div class="font-semibold">
                    {{ __('Proof of Payment') }}
                </div>
                <embed type="application/pdf" src="{{ $payment->storageFile(true) }}" width="100%"
                    height="600"></embed>
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
