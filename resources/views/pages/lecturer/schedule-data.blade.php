<x-modal.body>
    @if (!$isLoading)
        <div class="flex justify-end">
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
                @if (!empty($schedules))
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
                                {{ $schedule['student_total'] }}
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="9">
                                <x-no-data />
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                @else
                    <x-table.tr>
                        <x-table.td colspan="9">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endif
            </x-slot>
        </x-table>
    @else
        <x-loading />
    @endif
</x-modal.body>
