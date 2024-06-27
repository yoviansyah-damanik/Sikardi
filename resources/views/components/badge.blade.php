<div x-data='{ id: $id("badge")}' {{ $attributes->merge(['class' => $badgeClass]) }}>
    {{ $slot }}
</div>
