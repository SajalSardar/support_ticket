<button {{ $attributes->merge(['type' => 'submit', 'class' => 'hover:bg-primary-400 hover:text-gray-100 border border-base-500 px-8 py-2 bg-background-gray text-paragraph rounded']) }}>
    {{ $slot }}
</button>