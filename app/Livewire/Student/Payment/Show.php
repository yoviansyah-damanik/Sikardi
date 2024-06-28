<?php

namespace App\Livewire\Student\Payment;

use App\Models\Payment;
use Livewire\Component;

class Show extends Component
{
    protected $listeners = ['setShowPayment', 'clearModal'];

    public ?Payment $payment = null;
    public bool $isLoading = true;

    public function render()
    {
        return view('pages.student.payment.show');
    }

    public function clearModal()
    {
        $this->reset();
        $this->isLoading = true;
    }

    public function setShowPayment(Payment $payment)
    {
        $this->isLoading = true;
        $this->payment = $payment;
        $this->isLoading = false;
    }
}
