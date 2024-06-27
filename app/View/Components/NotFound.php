<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Component;

class NotFound extends Component
{
    public string $url;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $text = 'data'
    ) {
        $this->url = Vite::image('not_found.gif');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.not-found');
    }
}
