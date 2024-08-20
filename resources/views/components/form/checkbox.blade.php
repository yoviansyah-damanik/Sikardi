<div>
    <div x-data="{
        id: $id('{{ $attributes->whereStartsWith('wire:model')->first() }}'),
    }" class="{{ $wrapClass }}">
        <input type="checkbox" class="{{ $baseClass }}" :id="id" {{ $attributes }}
            wire:loading.attr='disabled' @required($required) @disabled($loading) />
        @if ($label)
            <label :for="id" class="{{ $labelClass }}">
                {{ $label }} </label>
        @endif
    </div>
    @if ($error)
        <div class="{{ $errorClass }}">
            {{ $error }}
        </div>
    @enderror
</div>
