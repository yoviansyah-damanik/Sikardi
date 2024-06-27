<x-content>
    <x-content.title :title="__('Guidance\'s Student')" :description="__('Guidance student status information.')" />

    <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />

    <x-table :columns="[
        '#',
        'NPM',
        __('Fullname'),
        __('Semester'),
        __('Stamp'),
        __('Gender'),
        __('Address'),
        __(':status Status', ['status' => __('CSS')]),
        __(':status Status', ['status' => __('Passed')]),
        '',
    ]">
        <x-slot name="body">
            @forelse ($students as $student)
                <x-table.tr>
                    <x-table.td centered>
                        {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['npm'] }}
                    </x-table.td>
                    <x-table.td>
                        {{ $student['data']['name'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['semester'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['stamp'] }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $student['data']['gender'] }}
                    </x-table.td>
                    <x-table.td>
                        {{ $student['data']['address'] }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$student['status'] == 'approved'
                            ? 'success'
                            : ($student['status'] == 'waiting'
                                ? 'warning'
                                : 'error')">
                            {{ __(Str::headline($student['status'])) }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$student['is_passed']['status'] ? 'success' : 'warning'">
                            {{ $student['is_passed']['message'] }}
                        </x-badge>
                        @if ($student['is_passed']['status'])
                            <div class="mt-3 font-bold text-center">
                                {{ $student['is_passed']['data']['grade_number'] }}
                                ({{ $student['is_passed']['data']['grade'] }})
                            </div>
                        @endif
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('View')">
                            <x-button color="cyan" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-student-modal')"
                                wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('View :view', ['view' => __('CSS')])">
                            <x-button color="yellow" icon="i-ph-list-heart" size="sm"
                                x-on:click="$dispatch('toggle-show-student-css-modal')"
                                wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
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

        <x-slot name="paginate">
            {{ $students->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-student-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Student')])">
            <livewire:student.show-data />
        </x-modal>
        <x-modal name="show-student-css-modal" size="full" :modalTitle="__('Show :show', ['show' => __('CSS')])">
            <livewire:student.show-data-css />
        </x-modal>
    </div>
</x-content>
