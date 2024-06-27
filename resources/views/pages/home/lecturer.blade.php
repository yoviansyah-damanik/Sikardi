<x-content>
    <x-box-grid>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('lecturer.student')" :title="__('Active Students')" :number="$activeStudents"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('lecturer.student')" :title="__('Students Passed')" :number="$studentsPassed"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('lecturer.student')" :title="__(':total Total', ['total' => __('Guidance\'s Student')])" :number="$guidancesStudent"></x-box>
    </x-box-grid>

    <div class="p-6 bg-white shadow dark:bg-slate-800 sm:p-8">
        <div class="text-xl font-bold text-center uppercase text-primary-700 dark:text-primary-300">
            {{ __("Today's Lecture Schedule") }}
        </div>
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
