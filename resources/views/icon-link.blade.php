<a href="{{ $href }}" target="{{ $target ?? '_self' }}" rel="{{ $rel ?? ''}}" class="flex items-center space-x-2 font-semibold link">
    @if(! ($hideIcon ?? false))<span>@svg('link', 'h-4 w-4')</span>@endif
    <span>{{ $slot }}</span>
</a>
