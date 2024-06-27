<div
    class="relative flex items-start justify-between px-4 py-3 border-b sm:px-6 sm:py-4 bg-primary-100 dark:bg-slate-900 dark:text-gray-100">
    <div class="flex-1 font-semibold">
        {{ $title }}
    </div>
    <x-button color="transparent" size="sm" x-on:click="closeModal" base="min-h-0 min-w-0 !p-0">
        <span class="i-ph-x-bold size-4"></span>
    </x-button>
</div>
