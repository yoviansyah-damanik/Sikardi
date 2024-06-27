<x-content>
    <x-content.title :title="__('Curricula')" :description="__('List of available curricula.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Curriculum')]),
            '2' => __(':name Name', ['name' => __('Curriculum')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateCurriculum')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Curriculum')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Curriculum')]),
            '2' => __(':name Name', ['name' => __('Curriculum')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button block color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateCurriculum')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Curriculum')]) }}</x-button>
    </div>


    <x-table :columns="[
        '#',
        __('Code'),
        __(':name Name', ['name' => __('Curriculum')]),
        __('Description'),
        __('Year'),
        __('Courses'),
        __('Lectures'),
        __('Status'),
        '',
    ]">
        <x-slot name="body">
            @forelse ($curricula as $curriculum)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $curricula->perPage() * ($curricula->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $curriculum->code }}
                    </x-table.td>
                    <x-table.td>
                        {{ $curriculum->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $curriculum->description }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $curriculum->year }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Courses')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-courses-modal')"
                                wire:click="$dispatch('setShowCourses', { curriculum: '{{ $curriculum->id }}' })">
                                {{ $curriculum->courses()->count() }}
                                {{ $curriculum->courses()->count() <= 1 ? __('Course') : __('Courses') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Lectures')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-lectures-modal')"
                                wire:click="$dispatch('setShowLectures', { type:'curriculum', curriculum: '{{ $curriculum->id }}' })">
                                {{ $curriculum->lectures()->count() }}
                                {{ $curriculum->lectures()->count() <= 1 ? __('Lecture') : __('Lectures') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="$curriculum->is_active ? __('Deactivate') : __('Activate')">
                            <x-button :icon="$curriculum->is_active ? 'i-ph-check' : 'i-ph-x'" wire:click='setActive({{ $curriculum->id }})' size="sm"
                                :color="$curriculum->is_active ? 'green' : 'red'">
                                {{ $curriculum->is_active ? __('Active') : __('Inactive') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('Edit :edit', ['edit' => __('Curriculum')])">
                            <x-button color="yellow" icon="i-ph-pen" size="sm"
                                x-on:click="$dispatch('toggle-edit-modal')"
                                wire:click="$dispatch('setEditCurriculum', { curriculum: '{{ $curriculum->id }}' })">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('Delete :delete', ['delete' => __('Curriculum')])">
                            <x-button color="red" icon="i-ph-trash" size="sm"
                                x-on:click="$dispatch('toggle-delete-modal')"
                                wire:click="$dispatch('setDeleteCurriculum', { curriculum: '{{ $curriculum->id }}' })">
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="7">
                        <x-no-data />
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-slot>

        <x-slot name="paginate">
            {{ $curricula->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-lectures-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lectures')])">
            <livewire:staff.lecture.show-data />
        </x-modal>
        <x-modal name="show-courses-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Courses')])">
            <livewire:staff.course.show-data />
        </x-modal>
        <x-modal name="create-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Curriculum')])">
            <livewire:staff.curriculum.create />
        </x-modal>
        <x-modal name="edit-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Curriculum')])">
            <livewire:staff.curriculum.edit />
        </x-modal>
        <x-modal name="delete-modal" size="xl" :modalTitle="__('Delete :delete', ['delete' => __('Curriculum')])">
            <livewire:staff.curriculum.delete />
        </x-modal>
    </div>
</x-content>
