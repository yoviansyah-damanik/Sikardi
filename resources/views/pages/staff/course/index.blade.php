<x-content>
    <x-content.title :title="__('Courses')" :description="__('List of available courses.')" />

    <x-alert type="info" :closeButton="false">
        {{ __('Active Curriculum') }}: <strong>{{ "($activeCurriculum->code) " . $activeCurriculum->name }}</strong>
    </x-alert>

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Course')]),
            '2' => __(':name Name', ['name' => __('Course')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$semesters,
        ]" wire:model.live='semester' />
        <x-button color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateCourse')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Course')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Course')]),
            '2' => __(':name Name', ['name' => __('Course')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-form.select block :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$semesters,
        ]" wire:model.live='semester' />
        <x-button block color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateCourse')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Course')]) }}</x-button>
    </div>

    <x-table :columns="[
        '#',
        __('Code'),
        __(':name Name', ['name' => __('Course')]),
        __('CC'),
        __('Semester'),
        __('Description'),
        __('Lectures'),
        '',
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
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Lectures')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-lectures-modal')"
                                wire:click="$dispatch('setShowLectures', { type: 'course', course: {{ $course->id }} })">
                                {{ $course->lectures()->count() }}
                                {{ $course->lectures()->count() <= 1 ? __('Lecture') : __('Lectures') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('Edit :edit', ['edit' => __('Course')])">
                            <x-button color="yellow" icon="i-ph-pen" size="sm"
                                x-on:click="$dispatch('toggle-edit-modal')"
                                wire:click="$dispatch('setEditCourse', { course: {{ $course->id }} })">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('Delete :delete', ['delete' => __('Course')])">
                            <x-button color="red" icon="i-ph-trash" size="sm"
                                x-on:click="$dispatch('toggle-delete-modal')"
                                wire:click="$dispatch('setDeleteCourse', { course: {{ $course->id }} })">
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
            {{ $courses->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-lectures-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lectures')])">
            <livewire:staff.lecture.show-data />
        </x-modal>
        <x-modal name="create-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Course')])">
            <livewire:staff.course.create :$semesters :$activeCurriculum />
        </x-modal>
        <x-modal name="edit-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Course')])">
            <livewire:staff.course.edit :$semesters :$activeCurriculum />
        </x-modal>
        <x-modal name="delete-modal" size="xl" :modalTitle="__('Delete :delete', ['delete' => __('Course')])">
            <livewire:staff.course.delete />
        </x-modal>
    </div>
</x-content>
