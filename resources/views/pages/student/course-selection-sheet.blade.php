<x-content>
    <x-content.title :title="__('Course Selection Sheet (CSS)')" :description="__('List of your Course Selection Sheet (CSS).')" />

    <x-student-information :$student />

    @foreach (range(1, $student['data']['semester']) as $semester)
        <div class="border-b py-9 mb-9 last:border-b-0 border-primary-700 dark:border-gray-700">
            <livewire:student.course-selection-sheet-data :$student :$semester />
        </div>
    @endforeach
</x-content>
