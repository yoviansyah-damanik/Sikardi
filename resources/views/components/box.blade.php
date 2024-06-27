<div class="{{ $baseClass }}">
    <div class="flex items-center justify-end flex-none gap-2">
        <div class="{{ $dotClass }}"></div>
        <div class="{{ $dotClass }}"></div>
        <div class="{{ $dotClass }}"></div>
    </div>
    <div class="{{ $numberClass }}">
        {{ NumberHelper::format($number) }}
    </div>

    <div class="{{ $titleClass }}">
        {{ $title }}
    </div>

    @if ($description)
        <div class="{{ $descriptionClass }}" alt="{{ $description }}">{{ $description }}</div>
    @endif

    @if ($icon)
        <div class="absolute top-0 left-0 z-[-1]">
            <span class="{{ $iconClass }}"></span>
        </div>
    @endif

    @if ($to)
        <a class="before:absolute before:inset-0 before:z-10" href="{{ $to }}" wire:navigate></a>
    @endif
</div>
