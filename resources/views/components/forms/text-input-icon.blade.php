<div class="relative">
    <input style="height: 40px;" type="{{ $type }}" {!! $attributes->merge([
    'class' => 'text-paragraph w-full ps-10 border border-[#dddddd] focus:ring-transparent focus:border-primary-400 rounded bg-transparent',
    ]) !!} />
    <span class="absolute inset-y-0 {{ $dir }}-0 grid w-10 place-content-center">
        {{ $slot }}
    </span>
</div>