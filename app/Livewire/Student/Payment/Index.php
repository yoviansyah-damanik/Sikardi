<?php

namespace App\Livewire\Student\Payment;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshPayment' => '$refresh'];

    public function render()
    {
        $payments = \App\Models\Payment::with('student')
            ->where('student_id', auth()->user()->data->id)
            ->paginate(15);

        return view('pages.student.payment.index', compact('payments'))
            ->title(__('Payment'));
    }
}
