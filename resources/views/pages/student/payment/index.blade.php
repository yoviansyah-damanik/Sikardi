<x-content>
    <x-content.title :title="__('Payment')" :description="__('List of tuition payments.')" />

    <div class="flex justify-end">
        <x-button color="primary" icon="i-ph-plus" wire:click="$dispatch('setCreatePayment')"
            x-on:click="$dispatch('toggle-create-payment-modal')">{{ __('Add :add', ['add' => __('Payment')]) }}</x-button>
    </div>

    <x-table :columns="[
        '#',
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
                    <x-table.td>
                        <div class="font-semibold">
                            {{ $payment->student->name }}
                        </div>
                        NPM. {{ $payment->student->id }}
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
                        <x-tooltip :title="__('View')">
                            <x-button color="cyan" icon="i-ph-eye" size="sm"
                                x-on:click="$dispatch('toggle-show-payment-modal')"
                                wire:click="$dispatch('setShowPayment', { payment: '{{ $payment->id }}' } )">
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
            {{ $payments->links(data: ['scrollTo' => 'table']) }}
        </x-slot>
    </x-table>

    <div wire:ignore>
        <x-modal name="show-payment-modal" size="3xl" :modalTitle="__('Show :show', ['show' => __('Payment')])">
            <livewire:student.payment.show />
        </x-modal>
        <x-modal name="create-payment-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Payment')])">
            <livewire:student.payment.create />
        </x-modal>
    </div>
</x-content>
