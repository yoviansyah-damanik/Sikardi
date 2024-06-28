<x-content>
    <x-content.title :title="__('Payment')" :description="__('List of tuition payments.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="[
            [
                'value' => 'all',
                'title' => __('All'),
            ],
            ...$types,
        ]" wire:model.live='type' />
    </div>

    <div class="flex gap-3 sm:hidden">
        <x-form.input block class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block
            wire:model.live.debounce.750ms='search' />
    </div>

    <x-table :columns="[
        '#',
        __('NPM'),
        __('Fullname'),
        __('Semester'),
        __('Action Time'),
        __('Confirmation Time'),
        __(':status Status', ['status' => __('Payment')]),
        '',
    ]">
        <x-slot name="body">
            @forelse ($payments as $payment)
                <x-table.tr>
                    <x-table.td class="w-16" centered>
                        {{ $payments->perPage() * ($payments->currentPage() - 1) + $loop->iteration }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $payment->student->id }}
                    </x-table.td>
                    <x-table.td>
                        {{ $payment->student->name }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $payment->semester }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $payment->created_at->translatedFormat('d F Y H:i:s') }}
                    </x-table.td>
                    <x-table.td centered>
                        {{ $payment->status != 'waiting' ? $payment->updated_at->translatedFormat('d F Y H:i:s') : '-' }}
                    </x-table.td>
                    <x-table.td centered>
                        <x-badge :type="$payment->status == 'paid'
                            ? 'success'
                            : ($payment->status == 'waiting'
                                ? 'warning'
                                : 'error')">
                            {{ __(Str::headline($payment->status)) }}
                        </x-badge>
                    </x-table.td>
                    <x-table.td centered class="w-36">
                        <x-tooltip :title="__('Confirmation')">
                            <x-button color="green" icon="i-ph-check" size="sm"
                                x-on:click="$dispatch('toggle-confirmation-payment-modal')"
                                wire:click="$dispatch('setConfirmationPayment', { payment: '{{ $payment->id }}' } )">
                            </x-button>
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
            {{ $payments->links(data: ['scrollTo' => 'table']) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="confirmation-payment-modal" size="3xl" :modalTitle="__('Payment Confirmation')">
            <livewire:staff.payment.confirmation />
        </x-modal>

    </div>
</x-content>
