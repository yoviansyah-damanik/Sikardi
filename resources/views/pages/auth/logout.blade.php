<div class='w-full' :class="$store.showSidebar ? 'mx-3' : ''">
    <button
        class="flex items-center justify-center w-full h-10 gap-1 py-3 text-white transition duration-150 bg-red-700 hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-700"
        :class="$store.showSidebar ? 'rounded-full' : ''" wire:click='logout'>
        <span class="i-solar-square-bottom-down-line-duotone size-4"></span>
        <span class="texs-base" x-show="$store.showSidebar">
            Logout
        </span>
    </button>
</div>
