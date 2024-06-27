<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public ?string $buttonClass = null,
    ) {
        $this->buttonClass = join(' ', [
            'flex items-center gap-2 bg-white px-5 py-2.5 rounded-md shadow',
            $buttonClass
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dropdown');
    }
}
