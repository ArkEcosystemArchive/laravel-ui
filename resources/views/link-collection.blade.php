<div class="grid grid-flow-row grid-cols-1 link-collection gap-x-3 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($links as $link)
        <div class="py-1">
            <a href="{{ $link[ $urlProperty ?? 'path'] }}" class="flex items-center justify-between w-full px-2 py-3 rounded transition-default text-theme-primary-600 hover:bg-theme-primary-100 hover:text-theme-primary-700" @if ($isExternal ?? false) target="_blank" rel="noopener nofollow noreferrer" @endif>
                <span>{{ $link['name'] }}</span>
                @svg('arrow-right', 'h-6 w-6')
            </a>
        </div>
    @endforeach
</div>
