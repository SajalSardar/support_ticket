@props(['disabled' => false])

<input style="height: 40px;" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full border border-base-500 focus:ring-primary-400 focus:border-primary-400 dark:focus:ring-primary-400 dark:focus:border-primary-400 rounded bg-transparent text-paragraph']) !!}>