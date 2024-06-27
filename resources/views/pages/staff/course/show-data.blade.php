<x-modal.body>
    @if (!$isLoading)
        @if (!empty($courses))
            <div class="mb-4">
                <x-form.input type="search" :placeholder="__('Search by :1 or :2', [
                    '1' => __(':code Code', ['code' => __('Course')]),
                    '2' => __(':name Name', ['name' => __('Course')]),
                ])" block wire:model.live.debounce.750ms='search' />
            </div>
            <x-table :columns="[
                '#',
                __('Code'),
                __(':name Name', ['name' => __('Course')]),
                __('CC'),
                __('Semester'),
                __('Description'),
            ]">
                <x-slot name="body">
                    @forelse ($courses as $course)
                        <x-table.tr>
                            <x-table.td class="w-16" centered>
                                {{ $courses->perPage() * ($courses->currentPage() - 1) + $loop->iteration }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $course->code }}
                            </x-table.td>
                            <x-table.td>
                                {{ $course->name }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $course->credit }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $course->semester }}
                            </x-table.td>
                            <x-table.td>
                                {{ $course->description }}
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="6">
                                <x-no-data />
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>

                <x-slot name="paginate">
                    {{ $courses->links(data: ['scrollTo' => false]) }}
                </x-slot>
            </x-table>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
