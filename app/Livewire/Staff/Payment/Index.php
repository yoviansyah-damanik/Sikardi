<?php

namespace App\Livewire\Staff\Payment;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshPayment' => '$refresh'];

    #[Url]
    public ?string $search = null;

    public array $types;
    public string $type;

    public function mount()
    {
        $this->types = collect(PaymentStatus::names())
            ->map(fn ($item) => [
                'title' => __(Str::headline($item)),
                'value' => $item
            ])
            ->toArray();
        $this->type = 'all';
    }

    public function render()
    {
        $payments = \App\Models\Payment::with('student')
            ->whereHas('student', fn ($student) => $student->whereAny(['id', 'name'], 'like', $this->search . '%'));

        if ($this->type != 'all')
            $payments = $payments->where('status', $this->type);

        $payments = $payments
            ->latest()
            ->paginate(15);

        return view('pages.staff.payment.index', compact('payments'))
            ->title(__('Payment'));
    }
}
