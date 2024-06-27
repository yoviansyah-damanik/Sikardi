<x-content>
    <x-content.title :title="__('Lecturers')" :description="__('List of registered lecturer data.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NIDN', '2' => __(':name Name', ['name' => __('Lecturer')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="$activationTypes" wire:model.live='activationType' />
        <x-button color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-lecturer-modal')">{{ __('Add :add', ['add' => __('Lecturer')]) }}</x-button>
    </div>

    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NIDN', '2' => __(':name Name', ['name' => __('Lecturer')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select block :items="$activationTypes" wire:model.live='activationType' />
        <x-button block color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-lecturer-modal')">{{ __('Add :add', ['add' => __('Lecturer')]) }}</x-button>
    </div>

    <x-table :columns="[
        '#',
        'NIDN',
        __('Fullname'),
        __('Gender'),
        __('Phone Number'),
        __('Schedule'),
        __('Number of Guidance Students'),
        __('User Status'),
        '',
    ]">
        <x-slot name="body">
            @forelse ($lecturers as $lecturer)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $lecturers->perPage() * ($lecturers->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $lecturer->id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $lecturer->name }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $lecturer->genderFull }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $lecturer->phone_number }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Schedule')])">
                            <x-button color="cyan" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-schedule-modal')"
                                wire:click="$dispatch('setLecturerSchedule', { lecturer: '{{ $lecturer->id }}' })">
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('View :view', ['view' => __('Guidance\'s Student')])">
                            <x-button color="primary" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-guidances-student-modal')"
                                wire:click="$dispatch('setGuidancesStudent', { lecturer: '{{ $lecturer->id }}' })">
                                {{ $lecturer->supervisors()->count() }}
                                {{ $lecturer->supervisors()->count() <= 1 ? __('Student') : __('Students') }}
                            </x-button>
                        </x-tooltip>
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$lecturer->user->is_suspended ? 'error' : 'success'">
                            {{ $lecturer->user->is_suspended ? __('Suspended') : __('Active') }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td centered class="w-32">
                        <x-tooltip :title="__('Activation Menu')">
                            <x-button size="sm" icon="i-ph-user-check" color="green"
                                x-on:click="$dispatch('toggle-user-activation-modal')"
                                wire:click="$dispatch('setUserActivation',{ user: {{ $lecturer->user->id }} })" />
                        </x-tooltip>
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
            {{ $lecturers->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-guidances-student-modal" size="full" :modalTitle="__(':data Data', ['data' => __('Guidance\'s Student')])">
            <livewire:lecturer.show-guidances-student />
        </x-modal>
        <x-modal name="show-schedule-modal" size="full" :modalTitle="__('View :view', ['view' => __('Schedule')])">
            <livewire:lecturer.schedule-data :isModal="1" />
        </x-modal>
        <x-modal name="create-lecturer-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Lecturer')])">
            <livewire:lecturer.create />
        </x-modal>
        <x-modal name="user-activation-modal" size="xl" :modalTitle="__('User Activation')">
            <livewire:users.user-activation />
        </x-modal>
    </div>
</x-content>
