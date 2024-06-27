<?php

namespace App\View\Components;

use App\Helpers\CssHelper;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Theme extends Component
{
    public string $baseClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $base = ''
    ) {
        $this->baseClass = join(' ', ['flex items-center cursor-pointer select-none drop-shadow-lg', $base]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.theme');
    }
}
