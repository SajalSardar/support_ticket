<a {{ $attributes->merge(['type' => 'submit', 'class' => 'px-5 py-2 inline-block bg-primary-400 text-heading-light rounded']) }}>
    {{ $slot }}
</a>