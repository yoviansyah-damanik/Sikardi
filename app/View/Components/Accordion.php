<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Accordion extends Component
{
    public string $titleClass;
    public string $baseClass;
    public string $bodyClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $type = 'outline',
        public bool $open = false
    ) {
        $this->titleClass = join(' ', [
            'font-semibold sm:px-8 px-6 py-3 flex items-center gap-6 cursor-pointer',
            $this->variant($type)['title']
        ]);

        $this->baseClass = join(' ', [
            'w-full bg-white dark:bg-slate-800 shadow rounded-lg overflow-hidden',
            $this->variant($type)['base']
        ]);

        $this->bodyClass = join(' ', [
            'max-h-96 overflow-y-auto'
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordion');
    }

    public function variant($type)
    {
        $variant = [
            'outline' => [
                'title' => 'bg-white dark:bg-slate-800 text-primary-700 ',
                'base' => 'border border-primary-700'
            ],
            'fill' => [
                'title' => 'bg-primary-700 text-white ',
                'base' => 'border border-primary-700'
            ]
        ];

        return $variant[$type];
    }
}
