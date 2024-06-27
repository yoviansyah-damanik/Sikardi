<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $baseClass, $iconClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $type = 'default',
        public string $base = '',
        public string $icon = '',
        public bool $closeButton = true
    ) {
        $color = 'text-primary-800 bg-primary-50 dark:bg-gray-800 dark:text-primary-400';
        $iconType = 'i-solar-bell-bing-bold-duotone';

        if ($type == 'success') {
            $color = 'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400';
            $iconType = 'i-solar-check-circle-line-duotone';
        } elseif ($type == 'error') {
            $color = 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400';
            $iconType = 'i-solar-close-circle-line-duotone';
        } elseif ($type == 'info') {
            $color = 'text-cyan-800 bg-cyan-50 dark:bg-gray-800 dark:text-cyan-400';
            $iconType = 'i-solar-alarm-add-bold-duotone';
        } elseif ($type == 'warning') {
            $color = 'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300';
            $iconType = 'i-solar-danger-circle-line-duotone';
        } elseif ($type == 'default') {
            $color = 'text-gray-800 bg-gray-50 dark:bg-gray-800 dark:text-gray-300';
            $iconType = null;
        }

        $this->baseClass = join(
            ' ',
            [
                'relative p-6 mb-4 text-sm rounded-lg sm:p-8 sm:text-base',
                $base,
                $color
            ]
        );

        $this->iconClass = join(' ', [
            'size-6',
            $iconType,
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
