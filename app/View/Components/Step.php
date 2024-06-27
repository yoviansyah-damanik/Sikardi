<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Step extends Component
{
    public array $steps;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->steps = [
            'submission' => 'completed',
            'guidance' => [
                'recap' => 'on_going',
                'bab_1' => 'completed',
                'bab_2' => 'failed',
                'bab_3' => 'on_going',
                'bab_4' => null,
                'bab_5' => null,
                'all' => null,
            ],
            'finish' => null
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.step');
    }
}
