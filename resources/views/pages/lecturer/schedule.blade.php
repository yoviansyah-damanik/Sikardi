<x-content>
    <x-content.title :title="__('Lecture Schedule')" :description="__('Below is your schedule for this semester.')" />

    <div class="flex justify-end mb-3 sm:mb-4">
        <x-button color="primary" wire:click='download' icon="i-ph-download">
            {{ __('Download') }}
        </x-button>
    </div>

    <x-table :columns="[
        '#',
        __('Day'),
        __('Course'),
        __('Semester'),
        __('Lecturer'),
        __('Room'),
        __('Start Time'),
        __('End Time'),
        __('CC'),
        __(':total Total', ['total' => __('Student')]),
    ]">
        <x-slot name="body">
            @forelse ($schedules as $schedule)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered class="font-semibold">
                        {{ $schedule['day'] }}
                    </x-table.td>
                    <x-table.td>
                        <div class="font-semibold">
                            {{ $schedule['course'] }}
                        </div>
                        {{ $schedule['course_code'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $schedule['semester'] }}
                    </x-table.td>
                    <x-table.td>
                        <div class="font-semibold">
                            {{ $schedule['lecturer'] }}
                        </div>
                        NIDN. {{ $schedule['lecturer_id'] }}
                    </x-table.td>
                    <x-table.td>
                        <div class="font-semibold">
                            {{ $schedule['room'] }}
                        </div>
                        {{ $schedule['room_code'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $schedule['start_time'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $schedule['end_time'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $schedule['cc'] }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Students')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-lecture-students-modal')"
                                wire:click="$dispatch('setShowLectureStudents', { lecture: {{ $schedule['lecture_id'] }} })">
                                {{ $schedule['student_total'] }} ({{ $schedule['limit'] }})
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10">
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>
    </x-table>
    <div wire:ignore>
        <x-modal name="show-lecture-students-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lecture Student')])">
            <livewire:staff.lecture.show-student />
        </x-modal>
    </div>
</x-content>
