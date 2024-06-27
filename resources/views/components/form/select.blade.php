<div x-data='{ id: $id("{{ $attributes->whereStartsWith('wire:model')->first() }}")}'
    {{ $attributes->merge(['class']) }}>
    @if ($label)
        <label :for="id" class="{{ $labelClass }}">{{ $label }}</label>
    @endif
    <select :id="id" class="{{ $baseClass }}" {{ $attributes->whereStartsWith('wire:model') }}
        {{ $attributes }} wire:loading.attr='disabled' @required($required) @disabled($loading)>
        @foreach ($items as $item)
            <option value="{{ $item['value'] ?? $item }}">{{ $item['title'] ?? $item }}</option>
        @endforeach
    </select>
    @if ($error)
        <div class="{{ $errorClass }}">
            {{ $error }}
        </div>
    @else
        @if ($info)
            <div class="mt-1 text-sm text-gray-700 dark:text-gray-100 ms-4">
                {{ $info }}
            </div>
        @endif
    @enderror
</div>
