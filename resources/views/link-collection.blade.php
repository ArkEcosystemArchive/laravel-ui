<div class="link-collection grid gap-x-3 grid-cols-1 grid-flow-row sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($links as $link)
        <div class="py-1">
            <a href="{{ $link['path'] }}" class="flex items-center justify-between px-2 py-3 w-full transition-default text-theme-primary-600 hover:bg-theme-primary-100 hover:text-theme-primary-700 rounded">
                <span>{{ $link['name'] }}</span>
                @svg('arrow-right', 'h-6 w-6')
            </a>
        </div>
    @endforeach
</div>