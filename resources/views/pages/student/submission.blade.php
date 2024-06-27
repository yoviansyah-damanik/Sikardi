<x-content>
    <x-content.title :title="__('Submission')" :description="__('The application process for filling out the Course Selection Sheet (CSS) for the current semester.')" />

    <x-student-information :$student />

    @if (GeneralHelper::isFillingOpen())
        <x-alert type="success" :closeButton="false">
            {{ __('The schedule for filling out the Course Selection Sheet (CSS) has been opened. Make sure you have coordinated with your Academic Supervisor to make it easier to fill out your Course Selection Sheet (CSS).') }}<br />
        </x-alert>
    @else
        <x-alert type="warning" :closeButton="false">
            {{ __('The schedule for filling out the Course Selection Sheet (CSS) has not yet been opened this semester.') }}<br />
            {{ __('The filling schedule starts on the :start date and ends on the :end date.', ['start' => \Carbon\Carbon::parse(GeneralHelper::startDate())->translatedFormat('d F Y'), 'end' => \Carbon\Carbon::parse(GeneralHelper::endDate())->translatedFormat('d F Y')]) }}
        </x-alert>
    @endif

    @if (!empty($student['submission']))
        @if ($student['submission']['status'] == 'waiting')
            <x-alert type="info" :closeButton="false">
                {{ __('Your application has been made. Please wait for confirmation from your Academic Supervisor.') }}<br />
            </x-alert>
        @elseif ($student['submission']['status'] == 'revision')
            <x-alert type="warning" :closeButton="false">
                {{ __('Your submission needs to be revised.') }}<br />
                <strong>{{ __('Message') }}:</strong> {{ $student['submission']['message'] }}
            </x-alert>
        @elseif ($student['submission']['status'] == 'approved')
            <x-alert type="success" :closeButton="false">
                {{ __('Your submission has been approved.') }}<br />
                <strong>{{ __('Message') }}:</strong> {{ $student['submission']['message'] }}
            </x-alert>
        @else
            <x-alert type="error" :closeButton="false">
                Mau ngapain hayooo!
            </x-alert>
        @endif
    @endif

    @if (!empty($student['submission']) || ($student['submission'] && $student['submission']['status'] == 'revision'))
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
    @endif

    @if (empty($student['submission']) || ($student['submission'] && $student['submission']['status'] == 'revision'))
        <div class="sticky p-6 font-semibold bg-white rounded-lg shadow sm:p-8 dark:bg-slate-800 top-20">
            <div class="flex items-center gap-3 sm:gap-4">
                <div class="flex-1">
                    <div class="flex flex-col gap-3 sm:gap-4 sm:flex-row">
                        <div class="flex-1">
                            {{ __('The number of credits you can take is :cc credits.', ['cc' => $limit]) }}
                        </div>
                        <div class="flex-1 text-center sm:flex-none sm:text-end">
                            {{ __(':total Total', ['total' => __('CC')]) }}: {{ $creditTaken }}
                        </div>
                    </div>
                </div>
                <x-button color="primary" x-on:click="$dispatch('toggle-submission-confirmation-modal')"
                    wire:click='openSubmissionConfirmation' icon="i-ph-paper-plane-tilt">
                    {{ __('Submit') }}
                </x-button>
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
            __('Remainder'),
            __('CC'),
            '',
        ]">
            <x-slot name="body">
                @forelse ($lectures as $lecture)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered class="font-semibold">
                            {{ $lecture->day_name }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $lecture->course->name }}
                            </div>
                            {{ $lecture->course->code }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $lecture->course->semester }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $lecture->lecturer->name }}
                            </div>
                            NIDN. {{ $lecture->lecturer->id }}
                        </x-table.td>
                        <x-table.td>
                            <div class="font-semibold">
                                {{ $lecture->room->name }}
                            </div>
                            {{ $lecture->room->code }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ Str::substr($lecture->start_time, 0, 5) }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ Str::substr($lecture->end_time, 0, 5) }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $lecture->remainder }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $lecture->course->credit }}
                        </x-table.td>
                        <x-table.td centered>
                            <x-form.checkbox inline value="{{ $lecture->id }}" wire:model.live='lectureTaken'
                                wire:change='countCreditTaken' :loading="$isLoading | ($lecture->remainder == 0)" />
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="11">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>
        </x-table>

        <div wire:ignore>
            <x-modal name="submission-confirmation-modal" size="full" :modalTitle="__('Submission Confirmation')">
                <livewire:student.submission-confirmation />
            </x-modal>
        </div>
    @endif
</x-content>
