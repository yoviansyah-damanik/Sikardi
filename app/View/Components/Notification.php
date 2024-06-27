<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Notification extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $notifications = []
    ) {
        $this->notifications = \App\Models\Notification::owned()
            ->latest()
            ->limit(20)
            ->get()
            ->map(function ($notification) {
                return [
                    'from' => $notification->fromIdentify,
                    'from_model' => $notification->from_model == \App\Models\Student::class ? __('Student') : ($notification->from_model == \App\Models\Lecturer::class ? __('Lecturer') : __('Staff')),
                    'href' => $notification->href,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'created_at' => $notification->created_at
                ];
            })
            ->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification');
    }
}
