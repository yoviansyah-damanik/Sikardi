<?php

namespace App\Livewire\Lecturer;

use Livewire\Component;
use App\Helpers\DownloadHelper;
use App\Repository\LecturerRepository;

class Schedule extends Component
{
    public $schedules;

    public function mount()
    {
        $this->schedules = LecturerRepository::getSchedule(auth()->user()->data);
    }

    public function render()
    {
        return view('pages.lecturer.schedule')
            ->title(__('Lecture Schedule'));
    }

    public function download()
    {
        try {
            if (empty($this->schedules)) {
                $this->alert('error', __('No data found'));
                return;
            }

            return DownloadHelper::downloadPdf('lecturer-schedule', [
                'lecturer' => auth()->user()->data,
                'schedules' => $this->schedules,
                'year' =>  \Carbon\Carbon::now()->year . '/' . (\Carbon\Carbon::now()->year + 1)
            ], __('Lecture Schedule') . '_ILKOM_' . \Carbon\Carbon::now()->year . '_' . auth()->user()->data->name);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
