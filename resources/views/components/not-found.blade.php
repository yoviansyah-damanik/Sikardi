<div>
    <img {{ $attributes }} src="{{ $url }}">
    <div class="font-medium text-center">
        {{ __('No :data found', ['data' => Str::lower($text)]) }}
    </div>
</div>
