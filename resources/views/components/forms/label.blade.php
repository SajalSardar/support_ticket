<label {!! $attributes->merge(['class' => 'text-paragraph pb-1 block']) !!}>
    {{ $slot }}
    <span class="text-red-500">
        @if ($required == 'yes')
            *
        @endif
    </span>
</label>
