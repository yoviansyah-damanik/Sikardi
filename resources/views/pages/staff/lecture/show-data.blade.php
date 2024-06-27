<x-modal.body>
    @if (!$isLoading)
        @if (!empty($lectures))
            <x-table :columns="['#', __('Day'), __('Course'), __('Semester'), __('Room'), __('Start Time'), __('End Time')]">
                <x-slot name="body">
                    @forelse ($lectures as $lecture)
                        <x-table.tr>
                            <x-table.td class="w-16" centered>
                                {{ $lectures->perPage() * ($lectures->currentPage() - 1) + $loop->iteration }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $lecture->day_name }}
                            </x-table.td>
                            <x-table.td>
                                <div class="flex gap-3">
                                    <div class="w-20 text-end">
                                        ({{ $lecture->curriculum->code }})
                                    </div>
                                    <div class="w-20">
                                        ({{ $lecture->course->code }})
                                    </div>
                                    <div class="flex flex-1 gap-3">
                                        <div class="flex-1">
                                            {{ $lecture->course->name }}
                                        </div>
                                        <div class="w-16">
                                            {{ $lecture->course->credit }} {{ __('CC') }}
                                        </div>
                                    </div>
                                </div>
                            </x-table.td>
                            <x-table.td centered>
                                {{ $lecture->course->semester }}
                            </x-table.td>
                            <x-table.td>
                                <div class="flex gap-3">
                                    <div class="w-20">
                                        ({{ $lecture->room->code }})
                                    </div>
                                    <div class="flex-1 text-end">
                                        {{ $lecture->room->name }}
                                    </div>
                                </div>
                            </x-table.td>
                            <x-table.td centered>
                                {{ Str::substr($lecture->start_time, 0, 5) }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ Str::substr($lecture->end_time, 0, 5) }}
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="8">
                                <x-no-data />
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>

                <x-slot name="paginate">
                    {{ $lectures->links(data: ['scrollTo' => false]) }}
                </x-slot>
            </x-table>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
