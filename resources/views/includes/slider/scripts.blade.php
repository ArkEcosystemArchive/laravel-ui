<script>
    new Swiper('#swiper-{{ $id }}', {
        slidesPerView: 1,
        slidesPerGroup: 1,
        slidesPerColumn: 1,
        spaceBetween: {{ $spaceBetween }},
        @if($breakpoints)
            breakpoints: {!! $breakpoints !!},
        @else
            breakpoints: {
                @if ($columns > 1)
                375: {
                    slidesPerGroup: {{ $columns - 3 > 0 ? $columns - 3 : 2 }},
                    slidesPerView: {{ $columns - 3 > 0 ? $columns - 3 : 2 }},
                },
                640: {
                    slidesPerGroup: {{ $columns - 2 > 0 ? $columns - 2 : 3 }},
                    slidesPerView: {{ $columns - 2 > 0 ? $columns - 2 : 3 }}
                },
                1024: {
                    slidesPerGroup: {{ $columns - 1 > 0 ? $columns - 1 : 4 }},
                    slidesPerView: {{ $columns - 1 > 0 ? $columns - 1 : 4 }}
                },
                1280: {
                @else
                1024: {
                @endif
                    slidesPerGroup: {{ $columns }},
                    slidesPerView: {{ $columns }},
                    @if ($rows > 1)
                        slidesPerColumn: {{ $rows }},
                        slidesPerColumnFill: 'row',
                    @endif
                },
            },
        @endif
        loop: {{ $loop ? 'true' : 'false' }},
        loopFillGroupWithBlank: true,
        @if ($autoplay)
        autoplay: {
            delay: {{ $autoplayDelay }},
        },
        @endif
        @unless ($hideBullets)
        pagination: {
            el: '#swiper-{{ $id }} .swiper-pagination',
            clickable: {{ $hideNavigation && !$topPagination ? 'false' : 'true' }}
        },
        @endif
        @unless ($hideNavigation)
        navigation: {
            nextEl: '.swiper-{{ $id }}-pagination.swiper-button-next',
            prevEl: '.swiper-{{ $id }}-pagination.swiper-button-prev'
        },
        @endunless
        watchOverflow: true,
        allowTouchMove: {{ $allowTouch ? 'true' : 'false' }}
    });
</script>