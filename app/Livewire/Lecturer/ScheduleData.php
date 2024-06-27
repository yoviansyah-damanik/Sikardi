<?php

namespace App\Livewire\Lecturer;

use Livewire\Component;
use App\Models\Lecturer;
use App\Helpers\DownloadHelper;
use App\Repository\LecturerRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ScheduleData extends Component
{
    use LivewireAlert;
    protected $listeners = ['setLecturerSchedule', 'clearModal'];

    public ?Lecturer $lecturer;
    public bool $isLoading = true;
    public $schedules;

    public function render()
    {
        return view('pages.lecturer.schedule-data');
    }

    public function setLecturerSchedule(Lecturer $lecturer)
    {
        $this->isLoading = true;
        $this->reset('lecturer', 'schedules');
        $this->lecturer = $lecturer;
        $this->schedules = LecturerRepository::getSchedule($lecturer);
        $this->isLoading = false;
    }

    public function clearModal()
    {
        $this->reset('lecturer', 'schedules');
    }

    public function download()
    {
        try {
            if (empty($this->schedules)) {
                $this->alert('error', __('No data found'));
                return;
            }

            return DownloadHelper::downloadPdf('lecturer-schedule', [
                'lecturer' => $this->lecturer,
                'schedules' => $this->schedules
            ], __('Lecture Schedule') . '_ILKOM_' . \Carbon\Carbon::now()->year . '_' .  $this->lecturer->name);
        } catch (\Exception $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        } catch (\Throwable $e) {
            $this->alert('error', __('Something went wrong'), ['text' => $e->getMessage()]);
        }
    }
}
