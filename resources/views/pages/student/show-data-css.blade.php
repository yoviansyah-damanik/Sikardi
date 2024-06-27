<x-modal.body>
    @if (!$isLoading)
        @if (!empty($student))
            <div class="flex flex-col gap-3 sm:gap-4" key="css">
                <x-form.select :items="$semesters" wire:model.live='semester' block />

                <livewire:student.course-selection-sheet-data :$student :$semester />
            </div>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
