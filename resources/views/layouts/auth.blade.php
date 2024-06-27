<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ Vite::image('logo.svg') }}" type="image/x-icon">
    <title>{{ $title ?? 'Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="relative w-full overflow-auto min-h-dvh bg-gradient-to-br from-primary-100 to-primary-300 dark:from-slate-700 dark:to-slate-900 bg-grid">
    <header class="inset-x-0 top-0 z-10 flex items-center justify-between px-6 py-3 sm:fixed">
        <img class='w-16 pointer-events-none sm:w-24 drop-shadow-lg' src="{{ Vite::image('logo.png') }}" alt="Logo">
        <x-theme />
    </header>
    <main class="flex items-center justify-center pt-6 pb-24 sm:pt-16 sm:pb-12">
        {{ $slot }}
    </main>
    <footer
        class="absolute inset-x-0 bottom-0 z-10 px-4 pt-16 pb-1 text-sm text-center bg-transparent sm:pb-2 sm:px-6 lg:text-base dark:text-gray-100">
        <div class="flex flex-col justify-between lg:flex-row lg:gap-3">
            <div>
                {{ GeneralHelper::appFullname() }} ({{ GeneralHelper::appName() }})
            </div>
            <div class="flex flex-col items-center lg:gap-3 lg:flex-row">
                Program Studi Ilmu Komputer
                <a class="underline" target="_blank" href="https://ugn.ac.id/">Universitas Graha
                    Nusantara</a>
            </div>
        </div>
    </footer>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    @stack('scripts')
</body>

</html>
