<x-content>
    <x-content.title :title="__('Staff')" :description="__('List of registered staff data.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':type Id', ['type' => __('Staff')]),
            '2' => __(':name Name', ['name' => __('Staff')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-staff-modal')">{{ __('Add :add', ['add' => __('Staff')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', [
            '1' => __(':type Id', ['type' => __('Staff')]),
            '2' => __(':name Name', ['name' => __('Staff')]),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-button block color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-staff-modal')">{{ __('Add :add', ['add' => __('Staff')]) }}</x-button>
    </div>


    <x-table :columns="[
        '#',
        __(':type Id', ['type' => __('Staff')]),
        __('Fullname'),
        __('Gender'),
        __('Phone Number'),
        __('User Status'),
    ]">
        <x-slot name="body">
            @forelse ($staff as $staff_)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $staff->perPage() * ($staff->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $staff_->id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $staff_->name }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $staff_->genderFull }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $staff_->phone_number }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$staff_->user->is_suspended ? 'error' : 'success'">
                            {{ $staff_->user->is_suspended ? __('Suspended') : __('Active') }}
                        </x-badge>
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
            {{ $staff->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="create-staff-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Staff')])">
            <livewire:staff.create />
        </x-modal>
    </div>
</x-content>
