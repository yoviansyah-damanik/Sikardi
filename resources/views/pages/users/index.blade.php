<x-content>
    <x-content.title :title="__('User Management')" :description="__('Manage all user accounts.')" />

    <div class="flex gap-3">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', [
            '1' => 'NPM/NIDN/' . __(':type Id', ['type' => __('Staff')]),
            '2' => __('Fullname'),
        ])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="$userTypes" wire:model.live='userType' />
        <x-form.select :items="$activationTypes" wire:model.live='activationType' />

    </div>

    <x-table :columns="[
        '#',
        'NPM/NIDN/' . __(':type Id', ['type' => __('Staff')]),
        __('Fullname'),
        __('Email'),
        __('User Type'),
        __('Phone Number'),
        __('Last Login'),
        __('Status'),
        '',
    ]">
        <x-slot name="body">
            @forelse ($users as $user)
                <x-table.tr>
                    <x-table.td centered>
                        {{ $users->perPage() * ($users->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $user->id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $user->name }}
                    </x-table.td>
                    <x-table.td>
                        {{ $user->email }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge size="sm" :type="$user->type == \App\Models\Staff::class
                            ? 'success'
                            : ($user->type == \App\Models\Lecturer::class
                                ? 'error'
                                : 'warning')">
                            {{ __(Str::ucfirst($user->type::CALLED)) }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td>
                        {{ $user->phone_number }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->translatedFormat('d F Y H:i:s') : '-' }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$user->is_suspended ? 'error' : 'success'">
                            {{ $user->is_suspended ? __('Suspended') : __('Active') }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td centered>
                        <x-tooltip :title="__('Forgot Password')">
                            <x-button size="sm" icon="i-ph-key" color="cyan"
                                x-on:click="$dispatch('toggle-forgot-password-modal')"
                                wire:click="$dispatch('setForgotPassword',{ user: {{ $user->user_id }} })" />
                        </x-tooltip>
                        @if ($user->type != \App\Models\Staff::class)
                            <x-tooltip :title="__('Activation Menu')">
                                <x-button size="sm" icon="i-ph-user-check" color="green"
                                    x-on:click="$dispatch('toggle-user-activation-modal')"
                                    wire:click="$dispatch('setUserActivation',{ user: {{ $user->user_id }} })" />
                            </x-tooltip>
                        @endif
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
            {{ $users->links(data: ['scrollTo' => false]) }}
        </x-slot>
    </x-table>


    <div wire:ignore>

        <x-modal name="user-activation-modal" size="xl" :modalTitle="__('User Activation')">
            <livewire:users.user-activation />
        </x-modal>
        <x-modal name="forgot-password-modal" size="xl" :modalTitle="__('Forgot Password')">
            <livewire:users.forgot-password />
        </x-modal>
    </div>
</x-content>
