<a href="{{ $message['url'] }}" class="flex flex-1 py-6 px-6 border-b border-dotted select-none last:border-b-0 hover:bg-theme-secondary-100">
    <div class="mr-4">
        <img src="{{ $message['image'] }}" class="w-12 rounded-full" />
    </div>

    <div class="flex flex-col flex-1 w-5/6">
        <div class="flex">
            <div class="flex-1 font-semibold">
                {{ $message['name'] }}
            </div>

            <div class="w-32 font-semibold text-right text-theme-secondary-500">
                @if($message['isYours'] && $message['isRead'])
                    @svg('read', 'inline w-3 mr-2')
                @elseif($message['isYours'])
                    @svg('checkmark', 'inline w-3 mr-2')
                @endif

                <span class="text-xs">{{ $message['date'] }}</span>
            </div>
        </div>

        <div class="truncate">
            {{ $message['content'] }}
        </div>
    </div>
</a>
