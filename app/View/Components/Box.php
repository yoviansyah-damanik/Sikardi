<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Box extends Component
{
    public string $baseClass, $dotClass, $iconClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $color = 'primary',
        public string $to = '',
        public string $title = '',
        public string $description = '',
        public float $number = 0,
        public string $numberClass = '',
        public string $titleClass = '',
        public string $descriptionClass = '',
        public string $base = '',
        public string $icon = ''
    ) {
        $this->baseClass = join(' ', [
            'relative backdrop-blur p-4 bg-gradient-to-br rounded-xl overflow-hidden',
            'before:absolute before:z-0 before:bottom-0 before:inset-x-0 before:z-2 before:h-1/2 before:bg-gradient-to-b before:from-transparent before:to-black/10',
            $this->getColor($color)['base'],
            $base
        ]);

        $this->numberClass = join(' ', [
            'relative z-10 my-1 text-2xl font-black sm:text-4xl text-end',
            $this->getColor($color)['text'],
            $numberClass
        ]);

        $this->titleClass = join(' ', [
            'relative z-10 text-sm font-bold sm:text-base text-end',
            $titleClass,
            $this->getColor($color)['text'],
        ]);

        $this->descriptionClass = join(' ', [
            'relative z-10 text-xs sm:text-sm truncate text-end',
            $descriptionClass,
            $this->getColor($color)['text'],
        ]);

        $this->dotClass = join(' ', [
            'relative z-10 w-3 sm:w-4 h-3 sm:h-4 rounded-full',
            $this->getColor($color)['background'],
        ]);

        $this->iconClass = join(' ', [
            'size-24 sm:size-32 opacity-10 rotate-12',
            $icon,
            $this->getColor($color)['text'],
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.box');
    }

    public static function getColor($color): array
    {
        $colorVariants = [
            'primary' => [
                'text' => 'text-primary-700',
                'background' => 'bg-primary-700',
                'base' => 'from-primary-100/70 from-40% to-primary-300/70 to-60% dark:from-primary-950/70 dark:to-primary-950/40'
            ],
            'green' => [
                'text' => 'text-green-700',
                'background' => 'bg-green-700',
                'base' => 'from-green-100/70 from-40% to-green-300/70 to-60% dark:from-green-950/70 dark:to-green-950/40'
            ],
            'red' => [
                'text' => 'text-red-700',
                'background' => 'bg-red-700',
                'base' => 'from-red-100/70 from-40% to-red-300/70 to-60% dark:from-red-950/70 dark:to-red-950/40'
            ],
            'lotus' => [
                'text' => 'text-lotus-700',
                'background' => 'bg-lotus-700',
                'base' => 'from-lotus-100/70 from-40% to-lotus-300/70 to-60% dark:from-lotus-950/70 dark:to-lotus-950/40'
            ],
            'lime' => [
                'text' => 'text-lime-700',
                'background' => 'bg-lime-700',
                'base' => 'from-lime-100/70 from-40% to-lime-300/70 to-60% dark:from-lime-950/70 dark:to-lime-950/40'
            ],
            'purple' => [
                'text' => 'text-purple-700',
                'background' => 'bg-purple-700',
                'base' => 'from-purple-100/70 from-40% to-purple-300/70 to-60% dark:from-purple-950/70 dark:to-purple-950/40'
            ],
            'scampi' => [
                'text' => 'text-scampi-700',
                'background' => 'bg-scampi-700',
                'base' => 'from-scampi-100/70 from-40% to-scampi-300/70 to-60% dark:from-scampi-950/70 dark:to-scampi-950/40'
            ],
            'yellow' => [
                'text' => 'text-amber-700',
                'background' => 'bg-amber-700',
                'base' => 'from-amber-100/70 from-40% to-amber-300/70 to-60% dark:from-amber-950/70 dark:to-amber-950/40'
            ],
        ];

        return $colorVariants[$color];
    }
}
