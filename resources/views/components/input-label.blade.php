@props(['value'])

<label {{ $attributes->merge(['class' => 'text-title pb-1 block']) }}>
    {{ $value ?? $slot }}
</label>