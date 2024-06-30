<x-content>
    <x-alert :type="!empty($student['submission'])
        ? ($student['submission']['status'] == 'approved'
            ? 'success'
            : ($student['submission']['status'] == 'waiting'
                ? 'warning'
                : 'info'))
        : 'error'">
        {{ __(':status Status', ['status' => __('Course Selection Sheet (CSS)')]) }}:
        <strong>
            {{ !empty($student['submission']) ? __(Str::headline($student['submission']['status'])) : __('Not yet submitted') }}
        </strong>
    </x-alert>
    <x-alert :type="$student['payments'][$student['data']['semester'] - 1]['status'] == 'paid'
        ? 'success'
        : ($student['payments'][$student['data']['semester'] - 1]['status'] == 'waiting'
            ? 'warning'
            : 'error')">
        {{ __(':status Status', ['status' => __('Payment')]) }}:
        <strong>
            {{ __(Str::headline($student['payments'][$student['data']['semester'] - 1]['status'])) }}
        </strong>
    </x-alert>

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
</x-content>
