<label class="{{ $baseClass }}" x-data="theme">
    <div class="relative h-4 w-14">
        <input type="checkbox" :value="isDarkMode" class="sr-only peer" x-on:click="toggle" />
        <div class="absolute h-full -translate-x-1/2 bg-white rounded-full w-14 left-1/2 top-full">
        </div>
        <div
            class="absolute flex items-center justify-center w-6 h-6 overflow-hidden text-white transition border border-white rounded-full left-1 top-1 peer-checked:translate-x-full peer-checked:bg-scampi-950 bg-primary-300">
            {{-- dark mode --}}
            <span class="i-solar-moon-stars-bold-duotone" x-show="isDarkMode" x-transition.scale></span>
            {{-- light mode --}}
            <span class="i-solar-sun-2-bold-duotone" x-show="!isDarkMode" x-transition.scale></span>
        </div>
    </div>
</label>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('alpine:init', () => {
            let isDarkMode = false;

            const setTheme = (theme) => {
                if (!theme) {
                    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                            '(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                        isDarkMode = true;
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                        isDarkMode = false;
                    }
                } else {
                    localStorage.theme = theme;
                    isDarkMode = theme == 'dark' ? 'dark' : 'light';
                    document.documentElement.classList.toggle('dark');
                }
            }

            Alpine.data('theme', () => ({
                isDarkMode: isDarkMode,
                toggle() {
                    this.isDarkMode = !this.isDarkMode;
                    setTheme(this.isDarkMode ? 'dark' : 'light');
                },
            }));

            setTheme();
        });
    </script>
@endpush
