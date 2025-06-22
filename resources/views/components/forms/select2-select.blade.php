<select {!! $attributes->merge(['class' => 'select2 w-full focus:ring-transparent focus:border-primary-400 text-paragraph']) !!}>
    {{ $slot }}
</select>