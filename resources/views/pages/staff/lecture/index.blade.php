<x-content>
    <x-content.title :title="__('Lectures')" :description="__('List of available lectures.')" />

    <x-alert type="info" :closeButton="false">
        {{ __('Active Curriculum') }}: <strong>{{ "($activeCurriculum->code) " . $activeCurriculum->name }}</strong>
    </x-alert>

    <div class="hidden gap-3 sm:flex">
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$courses,
        ]" wire:model.live='course' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$semesters,
        ]" wire:model.live='semester' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$rooms,
        ]" wire:model.live='room' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$days,
        ]" wire:model.live='day' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$lecturers,
        ]" wire:model.live='lecturer' />
        <x-button color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateLecture')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Lecture')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$courses,
        ]" wire:model.live='course' />
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$semesters,
        ]" wire:model.live='semester' />
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$rooms,
        ]" wire:model.live='room' />
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$days,
        ]" wire:model.live='day' />
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$lecturers,
        ]" wire:model.live='lecturer' />
        <x-button block color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateLecture')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Lecture')]) }}</x-button>
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
                        {{ $lectures->perPage() * ($lectures->currentPage() - 1) + $loop->iteration }}
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
                        <x-tooltip :title="__('View :view', ['view' => __('Students')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-lecture-students-modal')"
                                wire:click="$dispatch('setShowLectureStudents', { lecture: {{ $lecture->id }} })">
                                {{ $lecture->limit }} ({{ $lecture->remainder }})
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td centered>
                        {{ $lecture->course->credit }}
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('Edit :edit', ['edit' => __('Lecture')])">
                            <x-button color="yellow" icon="i-ph-pen" size="sm"
                                x-on:click="$dispatch('toggle-edit-modal')"
                                wire:click="$dispatch('setEditLecture', { lecture: {{ $lecture->id }} })">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('Delete :delete', ['delete' => __('Lecture')])">
                            <x-button color="red" icon="i-ph-trash" size="sm"
                                x-on:click="$dispatch('toggle-delete-modal')"
                                wire:click="$dispatch('setDeleteLecture', { lecture: {{ $lecture->id }} })">
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="9">
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>

        <x-slot name="paginate">
            {{ $lectures->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-lecture-students-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lecture Student')])">
            <livewire:staff.lecture.show-student />
        </x-modal>
        <x-modal name="create-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Lecture')])">
            <livewire:staff.lecture.create :$lecturers :$activeCurriculum :$courses :$days :$rooms />
        </x-modal>
        <x-modal name="edit-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Lecture')])">
            <livewire:staff.lecture.edit :$lecturers :$activeCurriculum :$courses :$days :$rooms />
        </x-modal>
        <x-modal name="delete-modal" size="xl" :modalTitle="__('Delete :delete', ['delete' => __('Lecture')])">
            <livewire:staff.lecture.delete />
        </x-modal>
    </div>
</x-content>
