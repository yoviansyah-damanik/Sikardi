<header x-data class="sticky z-50 h-16 px-4 overflow-hidden transition-all duration-300 shadow-sm top-3">
    <div
        class="flex items-center justify-between gap-1 rounded-full shadow bg-white/30 dark:bg-slate-900/30 backdrop-blur">
        <div class="flex items-center flex-1 gap-3 ms-1">
            <x-button color="primary" base="text-base flex gap-3 h-full items-center group min-h-10 min-w-16"
                size="md" radius="rounded-full" x-on:click='$store.showSidebar = !$store.showSidebar'>
                <span x-show="!$store.showSidebar" x-transition
                    class="absolute inset-0 m-auto text-center i-solar-widget-4-bold-duotone"></span>
                <span x-show="$store.showSidebar" x-transition
                    class="absolute inset-0 m-auto text-center i-solar-widget-4-bold"></span>
            </x-button>
            <x-badge :type="GeneralHelper::currentSemester() == 'odd' ? 'success' : 'error'">
                {{ __(Str::headline(GeneralHelper::currentSemester())) }}
            </x-badge>
        </div>
        <div class="flex items-center flex-none gap-6">
            <x-theme base="-mt-5 hidden sm:block" />
            <x-header.user />
        </div>
    </div>
</header>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            Alpine.store('showSidebar', false);
        })
    </script>
@endpush
