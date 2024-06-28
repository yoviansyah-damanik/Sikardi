<?php

namespace App\Livewire\Student\Payment;

use App\Jobs\WaSender;
use App\Models\Payment;
use Livewire\Component;
use App\Helpers\WaHelper;
use App\Enums\PaymentStatus;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    const MAXFILE = 2 * 1024; // 2Mb
    const PATH = 'payments';

    public $file;
    public bool $isLoading = false;

    public function render()
    {
        return view('pages.student.payment.create');
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:pdf|max:' . self::MAXFILE,
        ];
    }

    public function validationAttributes()
    {
        return [
            'file' => __('Proof of Payment')
        ];
    }

    public function refresh()
    {
        $this->isLoading = true;
        $this->reset();
        $this->isLoading = false;
    }

    public function save()
    {
        $this->validate();
        $this->isLoading = true;

        DB::beginTransaction();
        try {
            $isExist = Payment::where([
                ['student_id', auth()->user()->data->id],
                ['semester', auth()->user()->data->semester],
            ])->first();

            if ($isExist) {
                if ($isExist->status == PaymentStatus::paid->name) {
                    $this->alert('warning', __('Your payment has been confirmed for that semester. You do not need to send proof of payment again.'));
                    $this->isLoading = false;
                    return;
                }

                if ($isExist->status == PaymentStatus::waiting->name) {
                    $this->alert('warning', __('You cannot add payments for that semester until the staff confirms the payment in question.'));
                    $this->isLoading = false;
                    return;
                }

                Storage::delete($isExist->file_url);
            }

            $file_url = $this->file->storePublicly(path: self::PATH);

            Payment::updateOrCreate([
                'student_id' => auth()->user()->data->id,
                'semester' => auth()->user()->data->semester,
            ], [
                'file_url' => $file_url,
                'status' => PaymentStatus::waiting->name
            ]);

            WaSender::dispatch(
                WaHelper::getTemplate('create_payment', [
                    'npm' => auth()->user()->data->id,
                    'name' => auth()->user()->data->name,
                    'semester' => auth()->user()->data->semester,
                ]),
                \App\Models\Staff::all()->pluck('phone_number')->toArray()
            );

            DB::commit();
            $this->alert('success', __('Successfully'), ['text' => __(':attribute created successfully.', ['attribute' => __('Payment')])]);
            $this->dispatch('refreshPayment');
            $this->dispatch('toggle-create-payment-modal');
            $this->reset();

            $this->isLoading = false;
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
