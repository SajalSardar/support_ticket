@if(isset($data) && count($data) > 0)
    <ul class="flex gap-x-1 items-center mb-8">
        @foreach ($data as $key => $item)
            <li>
                <a href="{{ $item['route'] }}" class="flex items-center {{ $loop->last ? 'text-active-breadcrumb' : 'text-title' }}">
                    <span class="{{ $loop->last ? 'text-primary-400' : '' }}">
                        {{ $item['title'] }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>
@endif