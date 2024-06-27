@if (session('alert'))
    <x-alert :type="session('alert-type')">
        {{ session('msg') }}
    </x-alert>
@endif

@if (auth()->user()->role == 'student' && auth()->user()->data->passed)
    <x-alert type="success" :closeButton="false">
        Cieeeee udah lulus...
    </x-alert>
@endif

@if (auth()->user()->role == 'student' && auth()->user()->data->is_finish)
    <x-alert type="success" :closeButton="false">
        Yeay! Kamu telah berhasil menyelesaikan semua bimbingan.
    </x-alert>
@endif
