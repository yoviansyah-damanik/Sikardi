<x-content>
    <x-content.title :title="__('Student Submission')" :description="__('Confirmation of the CC application by your Guidance Student.')" />

    <x-form.input type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />

    <x-table :columns="[
        '#',
        'NPM',
        __('Fullname'),
        __('Semester'),
        __('Stamp'),
        __(':total Total', ['total' => __('CC')]),
        __(':status Status', ['status' => __('CSS')]),
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
                        {{ $student['data']['stamp'] }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$student['status'] == 'approved'
                            ? 'success'
                            : ($student['status'] == 'waiting'
                                ? 'warning'
                                : ($student['status'] == 'revision'
                                    ? 'info'
                                    : 'error'))">
                            {{ __(Str::headline($student['status'])) }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('Confirm Submission')">
                            <x-button :href="route('lecturer.student-submission.approval', [
                                'student' => $student['data']['npm'],
                            ])" color="cyan" icon="i-ph-eye" size="sm"
                                icon="i-ph-arrow-right" />
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
</x-content>
