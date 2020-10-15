<div class="w-full">
    @if ($title ?? $viewAllUrl ?? false)
        <div class="flex mb-4">
            @if ($title ?? false)
                <div
                    class="flex-1 @if($titleClass ?? false) {{ $titleClass }} @else text-2xl @endif @if (!isset($viewAllUrl)) mb-5 @endif"
                >
                    {{ $title }}
                </div>
            @endif

            @if ($viewAllUrl ?? false)
                <div class="flex {{ $viewAllClass ?? '' }}">
                    <div class="flex-1 my-auto text-sm text-right">
                        <a href="{{ $viewAllUrl }}" class="link">View all</a>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Swiper -->
    <div class="relative @if(!isset($hideNavigation)) px-10 @endif">
        <div id="swiper-{{ $id }}" class="swiper-container @if ($rows ?? false) slider-multirow @endif">
            @if(isset($topPagination))
                <div class="swiper-pagination text-right mb-3 {{ $paginationClass ?? '' }}"></div>
            @endif

            <div class="swiper-wrapper">
                {{ $slot }}
            </div>

            @if(!isset($topPagination))
                <div class="swiper-pagination {{ $paginationClass ?? '' }}"></div>
            @endif
        </div>
        @if (!isset($hideNavigation))
            <div class="swiper-{{ $id }}-pagination swiper-button-next outline-none"></div>
            <div class="swiper-{{ $id }}-pagination swiper-button-prev outline-none"></div>
        @endif
    </div>

    <script>
        new Swiper('#swiper-{{ $id }}', {
            slidesPerView: 1,
            slidesPerGroup: 1,
            slidesPerColumn: 1,
            spaceBetween: {{ isset($spaceBetween) ? $spaceBetween : 0 }},
            @if($breakpoints ?? false)
                breakpoints: {{ $breakpoints }},
            @else
                breakpoints: {
                    @if (!isset($columns) || $columns > 1)
                    375: {
                        slidesPerGroup: {{ ($columns ?? 5) - 3 }},
                        slidesPerView: {{ ($columns ?? 5) - 3 }},
                    },
                    640: {
                        slidesPerGroup: {{ ($columns ?? 5) - 2 }},
                        slidesPerView: {{ ($columns ?? 5) - 2 }}
                    },
                    1024: {
                        slidesPerGroup: {{ ($columns ?? 5) - 1 }},
                        slidesPerView: {{ ($columns ?? 5) - 1 }}
                    },
                    1280: {
                    @else
                    1024: {
                    @endif
                        slidesPerGroup: {{ $columns ?? 5 }},
                        slidesPerView: {{ $columns ?? 5 }},
                        @if ($rows ?? false)
                        slidesPerColumn: {{ $rows }},
                        slidesPerColumnFill: 'row',
                        @endif
                    },
                },
            @endif
            loop: {{ $loop ?? 'false' }},
            loopFillGroupWithBlank: true,
            pagination: {
                el: '#swiper-{{ $id }} .swiper-pagination',
                clickable: {{ isset($hideNavigation) && !isset($topPagination) ? 'false' : 'true' }}
            },
            @if (!isset($hideNavigation))
            navigation: {
                nextEl: '.swiper-{{ $id }}-pagination.swiper-button-next',
                prevEl: '.swiper-{{ $id }}-pagination.swiper-button-prev'
            },
            @endif
            watchOverflow: true,
            allowTouchMove: {{ $allowTouch ?? true }}
        });
    </script>
</div>
