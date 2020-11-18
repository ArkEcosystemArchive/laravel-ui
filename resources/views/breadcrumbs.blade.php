<div class="h-16 w-full flex justify-center bg-theme-secondary-100 dark:bg-black">
    <div class="w-full h-full flex items-center justify-start text-sm text-theme-secondary-500 leading-relaxed px-8 mx-auto max-w-7xl">
        @foreach ($crumbs as $crumb)
            @if(isset($crumb['route']))
                <span>
                    <a
                        class="flex items-center font-semibold hover:underline transition-default @if($loop->last) text-theme-secondary-700 @endif"
                        href="{{ route($crumb['route'], empty($crumb['params']) ? [] : $crumb['params']) }}"
                    >
                        @if($loop->first && count($crumbs) > 1)
                            @svg('arrow-left', 'inline-block h-6 mr-3 my-auto')
                        @endif

                        <span>{{ $crumb['label'] }}</span>
                    </a>
                </span>
            @else
                <span class="font-semibold truncate @if($loop->last) text-theme-secondary-700 @endif">{{ $crumb['label'] }}</span>
            @endif

            @if(!$loop->last)
                <span class="mx-3"> | </span>
            @endif
        @endforeach
    </div>
</div>
