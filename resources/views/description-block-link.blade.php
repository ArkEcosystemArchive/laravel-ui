<a
    href="{{ $url }}"
    class="description-block description-block-link"
    @if($isExternal ?? false)
        target="_blank"
        rel="noopener nofollow noreferrer"
    @endif
>
    <div class="flex justify-center">
        <img
            @unless ($lazyLoad ?? false)
                src="{{ $image }}"
            @else
                lazy="{{ $image }}"
            @endif
            class="max-w-full"
        />
    </div>

    <div class="flex flex-col mt-8 space-y-4">
        @if($isExternal ?? false)
            <span class="text-xl font-bold text-theme-secondary-900">
                <div class="flex items-center space-x-2 link">
                    <span>{{ $title }}</span>

                    @svg('link', 'h-4 w-4 flex-shrink-0 mr-2')
                </div>
            </span>
        @else
            <span class="text-xl font-bold text-theme-secondary-900">
                @if ($url ?? false)
                    <div class="link">{{ $title }}</div>
                @else
                    {{ $title }}
                @endif
            </span>
        @endif

        <span class="paragraph-description">{{ $description }}</span>
    </div>
</a>
