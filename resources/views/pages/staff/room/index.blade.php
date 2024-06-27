<x-content>
    <x-content.title :title="__('Rooms')" :description="__('List of available rooms.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Room')]),
            '2' => __(':name Name', ['name' => __('Room')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateRoom')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Room')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':code Code', ['code' => __('Room')]),
            '2' => __(':name Name', ['name' => __('Room')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button block color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreateRoom')"
            x-on:click="$dispatch('toggle-create-modal')">{{ __('Add :add', ['add' => __('Room')]) }}</x-button>
    </div>


    <x-table :columns="['#', __('Code'), __(':name Name', ['name' => __('Room')]), __('Description'), __('Lectures'), '']">
        <x-slot name="body">
            @forelse ($rooms as $room)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $rooms->perPage() * ($rooms->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $room->code }}
                    </x-table.td>
                    <x-table.td>
                        {{ $room->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $room->description }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Lectures')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-lectures-modal')"
                                wire:click="$dispatch('setShowLectures', { type: 'room', room: {{ $room->id }} })">
                                {{ $room->lectures()->count() }}
                                {{ $room->lectures()->count() <= 1 ? __('Lecture') : __('Lectures') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td class="w-28" centered>
                        <x-tooltip :title="__('Edit :edit', ['edit' => __('Room')])">
                            <x-button color="yellow" icon="i-ph-pen" size="sm"
                                x-on:click="$dispatch('toggle-edit-modal')"
                                wire:click="$dispatch('setEditRoom', { room: '{{ $room->id }}' })">
                            </x-button>
                        </x-tooltip>
                        <x-tooltip :title="__('Delete :delete', ['delete' => __('Room')])">
                            <x-button color="red" icon="i-ph-trash" size="sm"
                                x-on:click="$dispatch('toggle-delete-modal')"
                                wire:click="$dispatch('setDeleteRoom', { room: '{{ $room->id }}' })">
                            </x-button>
                        </x-tooltip>
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
            {{ $rooms->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-lectures-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lectures')])">
            <livewire:staff.lecture.show-data />
        </x-modal>
        <x-modal name="create-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Room')])">
            <livewire:staff.room.create />
        </x-modal>
        <x-modal name="edit-modal" size="3xl" :modalTitle="__('Edit :edit', ['edit' => __('Room')])">
            <livewire:staff.room.edit />
        </x-modal>
        <x-modal name="delete-modal" size="xl" :modalTitle="__('Delete :delete', ['delete' => __('Room')])">
            <livewire:staff.room.delete />
        </x-modal>
    </div>
</x-content>
