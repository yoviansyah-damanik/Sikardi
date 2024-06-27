<div x-data
    class="fixed inset-0 flex-col bg-white shadow sm:sticky sm:top-0 sm:flex dark:bg-slate-900 z-[99] sm:z-0 group h-dvh"
    :class="$store.showSidebar ? 'w-full sm:w-auto flex' :
        'w-16 hidden'">
    <x-sidebar.header />

    {{-- MENU LIST --}}
    <div class="relative flex-1 w-full h-full overflow-y-hidden ">
        <ul class="relative w-full h-full pb-12 mt-3 overflow-y-auto sm:overflow-y-hidden sm:hover:overflow-y-auto">
            @foreach ($menu_group as $menus)
                @foreach ($menus as $menu)
                    <x-sidebar.item :$menu />
                @endforeach
                @if (!$loop->last)
                    <li>
                        <div class="w-full h-[1px] bg-gray-100 my-3"></div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    {{-- LOGOUT --}}
    <div class="flex items-center justify-center w-full h-16">
        <livewire:auth.logout />
    </div>
</div>
