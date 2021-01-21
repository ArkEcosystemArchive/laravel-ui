@props([
    'id',
    'title'                     => null,
    'titleClass'                => 'text-2xl',
    'titleTooltip'              => null,
    'viewAllUrl'                => null,
    'viewAllClass'              => '',
    'hideNavigation'            => false,
    'hideBullets'               => false,
    'topPagination'             => false,
    'paginationClass'           => '',
    'rows'                      => 1,
    'columns'                   => 5,
    'breakpoints'               => null,
    'spaceBetween'              => 0,
    'loop'                      => false,
    'allowTouch'                => true,
    'autoplay'                  => false,
    'autoplayDelay'             => 3000,
    'afterNavigation'           => false,
    'paginationWrapperClass'    => 'flex items-center justify-between',
])

<div class="w-full">
    @if ($title && $viewAllUrl)
        <div class="flex mb-4">
            <div class="flex-1 relative {{ $titleClass }}">
                {{ $title }}

                @if ($titleTooltip)
                    <x-ark-info :tooltip="$titleTooltip" class="absolute -top-10 ml-2" />
                @endif
            </div>

            <div class="flex {{ $viewAllClass }}">
                <div class="flex-1 my-auto text-sm text-right">
                    <a href="{{ $viewAllUrl }}" class="link">
                        @lang('ui::actions.view_all')

                        <x-ark-icon class="inline-block" name="chevron-right" size="2xs" />
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Swiper -->
    <div class="relative @unless($hideNavigation) px-10 @endunless">
        <div id="swiper-{{ $id }}" class="swiper-container @if ($rows > 1) slider-multirow @endif">
            @if (($title && !$viewAllUrl) || $topPagination)
                <div class="{{ $paginationWrapperClass }}">
                    @if($title && !$viewAllUrl)
                        <div class="flex-1 relative {{ $titleClass }} my-4">
                            {{ $title }}

                            @if ($titleTooltip)
                                <x-ark-info :tooltip="$titleTooltip" class="absolute -top-10 ml-2" />
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-3 space-x-4">
                        @if($topPagination)
                            <div class="swiper-pagination text-right {{ $paginationClass }}"></div>
                        @endif

                        @if($afterNavigation)
                            <div class="pl-3 leading-5 sm:border-l-2 border-theme-secondary-300">
                                {{ $afterNavigation }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="swiper-wrapper">
                {{ $slot }}
            </div>

            @unless($topPagination)
                <div class="swiper-pagination {{ $paginationClass }}"></div>
            @endunless
        </div>
        @unless ($hideNavigation)
            <div class="swiper-{{ $id }}-pagination swiper-button-next outline-none"></div>
            <div class="swiper-{{ $id }}-pagination swiper-button-prev outline-none"></div>
        @endunless
    </div>

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
</div>
