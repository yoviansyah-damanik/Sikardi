<?php

namespace App\View\Components;

use App\Helpers\CssHelper;
use Closure;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Button extends Component
{
    public string $baseClass,
        $bgClass;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $color = 'default',
        public bool $block = false,
        public string $radius = 'rounded-md',
        public string $base = '',
        public array $target = [],
        public string $size = 'md',
        public string $href = '',
        public bool $loading = false,
        public bool $disabled = false,
        public ?string $icon = null,
        public ?string $iconClass = null,
        public string $iconPosition = 'left',
    ) {
        $this->baseClass = join(' ', [
            'relative inline-block font-medium font-semibold transition duration-150 text-base',
            $this->sizeVariant($size),
            $block ? 'w-full text-center' : '',
            $this->bgClass = $this->colorVariant($color),
            $radius,
            $loading ? 'cursor-not-allowed' : 'cursor-pointer',
            $base
        ]);

        $this->iconClass = join(' ', [
            'size-4',
            $icon,
            $iconClass,
            $iconPosition == 'left' ? 'order-0' : 'order-1'
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }

    public static function colorVariant($color): string
    {
        $colorVariants = [
            'primary' => 'focus:outline-none text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900',
            'green' => 'focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-900',
            'red' => 'focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900',
            'cyan' => 'focus:outline-none text-white bg-cyan-500 hover:bg-cyan-600 focus:ring-4 focus:ring-cyan-300 dark:focus:ring-cyan-900',
            'yellow' => 'focus:outline-none text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900',
            'default' => 'text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700',
            'transparent' => 'bg-transparent dark:text-gray-100 dark:hover:text-primary-100 outline-none border-none',
            'inactive' => 'bg-gray-100 border border-gray-200'
        ];

        return $colorVariants[$color];
    }

    public function sizeVariant($size)
    {
        $sizeVariants = [
            'sm' => 'text-sm py-1.5 px-2',
            'md' => 'py-2.5 px-5'
        ];
        return $sizeVariants[$size];
    }
}
