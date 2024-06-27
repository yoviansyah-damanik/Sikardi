<div class="flex flex-col gap-3 sm:gap-4">
    <div class="p-6 bg-white shadow dark:bg-slate-800 sm:p-8">
        <div class="flex flex-col justify-start gap-3 sm:items-center sm:justify-between sm:flex-row sm:gap-4">
            <div class="flex-1">
                <div class="text-xl font-bold uppercase text-primary-700 dark:text-primary-300">
                    {{ __(':semester Semester', ['semester' => $semester]) }}
                </div>
                @if ($course_selection_sheet)
                    <div class="flex flex-col gap-3 mt-3 font-light sm:flex-row">
                        <div class="flex items-center gap-1">
                            <span class="i-ph-calendar size-6"></span>
                            {{ \Carbon\Carbon::parse($course_selection_sheet['date'])->translatedFormat('d F Y H:i:s') }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="i-ph-chalkboard-teacher-fill size-6"></span>
                            {{ !empty($course_selection_sheet['responsible_lecturer']) ? $course_selection_sheet['responsible_lecturer']['name'] : '-' }}
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="i-ph-crosshair size-6"></span>
                            {{ $course_selection_sheet['max_load'] }} {{ __('CC') }}
                        </div>
                    </div>
                @else
                    -
                @endif
            </div>
            @if (!empty($course_selection_sheet['details']))
                <div class="hidden sm:block">
                    <x-button wire:click='download' color="primary" icon="i-ph-download">{{ __('Download') }}</x-button>
                </div>
                <div class="block sm:hidden">
                    <x-button block wire:click='download' color="primary"
                        icon="i-ph-download">{{ __('Download') }}</x-button>
                </div>
            @endif
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
            @if (!empty($course_selection_sheet['details']))
                @forelse ($course_selection_sheet['details'] as $detail)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered class="font-semibold">
                            {{ $detail['day'] }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $detail['course'] }}
                            </div>
                            {{ $detail['course_code'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $detail['semester'] }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $detail['lecturer'] }}
                            </div>
                            NIDN. {{ $detail['lecturer_id'] }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $detail['room'] }}
                            </div>
                            {{ $detail['room_code'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $detail['start_time'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $detail['end_time'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $detail['cc'] }}
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="9">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
                <x-table.tr class="font-semibold text-white !bg-primary-700">
                    <x-table.td class="text-end" colspan=8>
                        {{ __(':total Total', ['total' => __('CC')]) }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $course_selection_sheet['cc_total'] }}
                    </x-table.td>
                </x-table.tr>
            @else
                <x-table.tr>
                    <x-table.td colspan="9">
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endif
        </x-slot>
    </x-table>
</div>
