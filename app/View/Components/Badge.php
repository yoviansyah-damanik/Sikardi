<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Badge extends Component
{
    public string $badgeClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'default',
        public string $size = 'md',
        public bool $bordered = false
    ) {
        $this->badgeClass = join(' ', [
            'inline-block shadow dark:bg-slate-900',
            $this->colorVariant($type),
            $this->sizeVariant($size),
            $bordered ? 'border' : 'border-0'
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }

    public function colorVariant($type)
    {
        $colorVariants = [
            'default' => 'bg-gray-100 text-black  dark:text-gray-100',
            'success' => 'bg-green-50 text-green-800 dark:text-green-300  border-green-800 dark:border-green-300',
            'error' => 'bg-red-50 text-red-800 dark:text-red-300  border-red-800 dark:border-red-300',
            'warning' => 'bg-yellow-50 text-yellow-600  border-yellow-600 dark:border-yellow-300 dark:text-yellow-300',
            'info' => 'bg-cyan-50 text-cyan-600  border-cyan-600 dark:border-cyan-300 dark:text-cyan-300',
        ];

        return $colorVariants[$type];
    }

    public function sizeVariant($size)
    {
        $sizeVariants = [
            'lg' => 'px-6 py-3 text-base',
            'md' => 'px-4 py-1 text-sm rounded-lg',
            'sm' => 'px-3 py-1 text-xs rounded-md',
        ];

        return $sizeVariants[$size];
    }
}
