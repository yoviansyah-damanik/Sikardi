<x-content>
    <x-content.title :title="__('Confirm Submission')" :description="__('Confirmation of the CC application by your Guidance Student.')" />

    <x-student-information :$student />

    <div class="flex flex-col items-center gap-3 sm:flex-row sm:gap-4">
        <div class="flex items-center flex-1 gap-3 sm:gap-4">
            <x-button color="red" :href="route('lecturer.student-submission')" icon="i-ph-arrow-left">
                {{ __('Back') }}
            </x-button>
            <x-button x-on:click="$dispatch('toggle-approval-confirmation-modal')"
                wire:click="$dispatch('setApprovalConfirmation',{ student: '{{ $student['data']['npm'] }}' })"
                color="primary" icon="i-ph-list">
                {{ __('Confirmation') }}
            </x-button>
        </div>
        <x-badge :type="$student['status'] == 'approved'
            ? 'success'
            : ($student['status'] == 'waiting'
                ? 'warning'
                : 'error')">
            {{ __(Str::headline($student['status'])) }}
        </x-badge>
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
            @forelse ($student['submission']['details'] as $detail)
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
                    {{ $student['submission']['cc_total'] }}
                </x-table.td>
            </x-table.tr>
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="approval-confirmation-modal" size="3xl" :modalTitle="__('Approval Confirmation')">
            <livewire:lecturer.approval-confirmation :$student />
        </x-modal>
    </div>
</x-content>
