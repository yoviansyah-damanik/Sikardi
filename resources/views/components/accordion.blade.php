<div x-data="{ id: $id('accordion'), open: {{ $open ? 'true' : 'false' }} }" :id="id" class="{{ $baseClass }}">
    <div class="{{ $titleClass }}" x-on:click="open = !open">
        <div class="flex-1">
            {{ $title }}
        </div>
        <div>
            <x-button x-show="!open" color="transparent" base="text-white px-0 py-0" size="sm" icon="i-ph-plus" />
            <x-button x-show="open" color="transparent" base="text-white px-0 py-0" size="sm" icon="i-ph-minus" />
        </div>
    </div>
    <div class="{{ $bodyClass }}" x-show="open">
        {{ $slot }}
    </div>
</div>
