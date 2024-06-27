<div class="relative flex flex-col items-center justify-center w-full h-64 px-1 mx-auto bg-no-repeat bg-cover bg-primary-100 before:absolute before:inset-0 dark:before:bg-primary-950/80 before:bg-primary-700/80"
    style="background-image: url('{{ Vite::image('ugn.jpg') }}')"
    :class="$store.showSidebar ? 'lg:w-80 sm:w-72 xl:w-[22rem] !px-3 gap-3' : 'w-16 gap-6'">
    <div class="relative mx-auto" :class="$store.showSidebar ? 'w-20' : 'w-12'">
        <img src="{{ Vite::image('logo.svg') }}" class="w-full" alt="Logo">
    </div>

    <div class="absolute inset-x-0 top-0 flex justify-between p-4 sm:hidden">
        <x-theme base="-mt-5" />
        <x-button color="transparent" size="sm" x-on:click="$store.showSidebar = !$store.showSidebar"
            base="min-h-0 min-w-0 p-0">
            <span class="i-ph-x-bold size-6 text-primary-100"></span>
        </x-button>
    </div>

    <div class="relative flex flex-col items-center justify-center gap-1 text-center">
        <div class="text-xl font-bold tracking-[0.5em] truncate text-primary-100"
            :class="$store.showSidebar ? '[writing-mode:horizontal-tb]' : '[writing-mode:vertical-rl]'">
            {{ GeneralHelper::appName() }}
        </div>
        <div class="text-sm font-normal text-primary-100" :class="$store.showSidebar ? 'block' : 'hidden'">
            {{ GeneralHelper::appFullname() }}
        </div>
        <div class="text-sm sm:text-xs text-sky-100" :class="$store.showSidebar ? 'block' : 'hidden'">
            <div>
                {{ __('Logged as') }} {{ Auth::user()->email }}
            </div>
            <div>
                {{ GeneralHelper::dateFormat(Auth::user()->last_login_at) }}
            </div>
        </div>
    </div>
</div>
