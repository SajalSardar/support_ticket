<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'hover:text-primary-400 border border-base-500 px-8 py-2 bg-white hover:bg-primary-700 text-paragraph rounded']) }}>
    {{ $slot }}
</button>