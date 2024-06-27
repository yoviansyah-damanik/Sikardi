<li>
    <div x-data="{ id: $id('menu-item-tooltip'), tooltip: false }" x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false" class="cursor-pointer"
        x-ref="tooltip" :id="id">
        <a href="{{ $menu['to'] }}" @class([
            'relative flex items-center justify-start h-12 gap-0 transition duration-150 dark:text-gray-100',
            $menu['isActive']
                ? 'bg-primary-100 dark:bg-slate-800'
                : 'hover:bg-primary-50 dark:hover:bg-slate-700',
        ]) wire:navigate x-on:click="$store.showSidebar = false"
            x-ref="item">
            <div @class([
                'relative grid flex-none w-16 h-full mx-auto overflow-hidden place-items-center',
                $menu['isActive'] ? 'bg-primary-700 text-white' : '',
            ]) :class="$store.showSidebar ? 'rounded-r-full' : 'rounded-none'">
                <span class="{{ $menu['icon'] }} size-6"></span>
            </div>
            <div class="flex-1 p-3 truncate" :class="$store.showSidebar ? 'block' : 'hidden'">
                {{ $menu['title'] }}
            </div>
        </a>
        <template x-teleport="body">
            <div role="tooltip" x-show="tooltip && !$store.showSidebar" x-anchor.right.offset.10="$refs.tooltip"
                class="hidden p-2 text-sm text-gray-100 rounded-md shadow z-[99] sm:block bg-slate-800 dark:bg-slate-600 dark:shadow-slate-500">
                {{ $menu['title'] }}
            </div>
        </template>
    </div>


</li>
