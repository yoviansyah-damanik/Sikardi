<div>
    <x-modal.body>
        @if (!$isLoading)
            @if ($submissions)
                @if ($limit > $totalCredit)
                    <x-alert type='warning'>
                        {{ __('You choose courses whose number of credits is below the credit limit.') }}
                    </x-alert>
                @endif
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
                ]">
                    <x-slot name="body">
                        @forelse ($submissions as $submission)
                            <x-table.tr>
                                <x-table.td class="w-16" centered>
                                    {{ $loop->iteration }}
                                </x-table.td>
                                <x-table.td centered class="font-semibold">
                                    {{ $submission['day_name'] }}
                                </x-table.td>
                                <x-table.td>
                                    <div class="font-semibold">
                                        {{ $submission['course']['name'] }}
                                    </div>
                                    {{ $submission['course']['code'] }}
                                    {{ __('CC') }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ $submission['course']['semester'] }}
                                </x-table.td>
                                <x-table.td>
                                    <div class="font-semibold">
                                        {{ $submission['lecturer']['name'] }}
                                    </div>
                                    NIDN. {{ $submission['lecturer']['id'] }}
                                </x-table.td>
                                <x-table.td>
                                    <div class="font-semibold">
                                        {{ $submission['room']['name'] }}
                                    </div>
                                    {{ $submission['room']['code'] }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ Str::substr($submission['start_time'], 0, 5) }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ Str::substr($submission['end_time'], 0, 5) }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ $submission['remainder'] }}
                                </x-table.td>
                                <x-table.td centered>
                                    {{ $submission['course']['credit'] }}
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
                            <x-table.td class="text-end" colspan=9>
                                {{ __(':total Total', ['total' => __('CC')]) }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $totalCredit }}
                            </x-table.td>
                        </x-table.tr>
                    </x-slot>
                </x-table>
            @else
                <x-no-data />
            @endif
        @else
            <x-loading />
        @endif
    </x-modal.body>
    @if ($submissions)
        <x-modal.footer>
            <x-button color="primary" wire:click='submit' :loading="$isLoading">
                {{ __('Submit') }}
            </x-button>
        </x-modal.footer>
    @endif
</div>
