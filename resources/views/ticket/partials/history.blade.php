<div class="grid grid-cols-2">
    <div class="wrapper mt-4">
        @if (is_object($histories) && $histories->count() > 0)
            @foreach ($histories as $item)
                <div class="flex gap-x-7" style="margin-top:16px">
                    <div class="time" style="width:140px;height:40px">
                        <p class="text-paragraph pb-1">{{ date('d M, Y', strtotime($item->created_at)) }}</p>
                        <span class="text-paragraph">{{ date('l h:i:a', strtotime($item->created_at)) }}</span>
                    </div>

                    <div class="overview" style="position:relative">
                        <div class="top w-[16px] h-[16px] rounded-full" style="background:#FFF4EC;border:1px solid #ddd;z-index:3">
                        </div>
                        <div style="width:1px;height:100%;border:1px dotted gray;position:absolute;left:50%;transform: translate(-50%);z-index:2">
                        </div>
                        <div class="-bottom-8 w-[16px] h-[16px] rounded-full absolute" style="background:#FFF4EC;border:1px solid #ddd;z-index:3">
                        </div>
                    </div>

                    <div class="details" style="width:556px;height:80px">
                        <div class="border border-base-500 p-3 rounded">
                            <h3 class="text-heading-dark pb-1">{{ $item->creator->name }} - {{ $item->note_type }}</h3>
                            <span class="text-paragraph">{!! $item?->note !!}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>