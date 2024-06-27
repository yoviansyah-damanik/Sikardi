<div x-data="{ id: $id('tooltip'), tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="inline cursor-pointer"
    x-ref="tooltip">
    {{ $slot }}
    <div role="tooltip" x-show="tooltip" x-anchor.offset.10="$refs.tooltip"
        class="z-50 p-2 text-sm text-center text-gray-100 rounded-md shadow max-w-40 bg-slate-800 dark:bg-slate-600 dark:shadow-slate-500">
        {{ $title }}
    </div>
</div>
