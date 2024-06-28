<?php

namespace App\Livewire\Staff\Payment;

use App\Jobs\WaSender;
use App\Models\Payment;
use Livewire\Component;
use App\Helpers\WaHelper;
use Illuminate\Support\Str;
use App\Enums\PaymentStatus;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Confirmation extends Component
{
    use LivewireAlert;
    protected $listeners = ['setConfirmationPayment', 'clearModal'];

    public ?Payment $payment = null;
    public bool $isLoading = true;

    public array $types;
    public string $type;

    public function mount()
    {
        $this->types = PaymentStatus::names();
    }

    public function render()
    {
        return view('pages.staff.payment.confirmation');
    }

    public function clearModal()
    {
        $this->reset('type', 'payment');
        $this->isLoading = true;
    }

    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in($this->types)
            ]
        ];
    }
    public function setConfirmationPayment(Payment $payment)
    {
        $this->isLoading = true;
        $this->payment = $payment;
        $this->type = $payment->status;
        $this->isLoading = false;
    }

    public function save()
    {
        $this->validate();
        try {
            $this->payment->update([
                'status' => $this->type
            ]);

            WaSender::dispatch(
                WaHelper::getTemplate('payment_confirm', [
                    'npm' => $this->payment->student->id,
                    'name' => $this->payment->student->name,
                    'semester' => $this->payment->semester,
                    'status' => __(Str::headline($this->type))
                ]),
                $this->payment->student->phone_number
            );

            DB::commit();
            $this->alert('success', __('Successfully'), ['text' => __(':attribute confirmed successfully.', ['attribute' => __('Payment')])]);
            $this->dispatch('refreshPayment');
            $this->dispatch('toggle-confirmation-payment-modal');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
            $this->isLoading = false;
        }
    }
}
