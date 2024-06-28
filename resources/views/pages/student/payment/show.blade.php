<x-modal.body>
    @if (!$isLoading)
        @if (!empty($payment))
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
            <embed type="application/pdf" src="{{ $payment->storageFile(true) }}" width="100%" height="600"></embed>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
