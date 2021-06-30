@props([
    'id',
    'title'           => null,
    'titleClass'      => 'text-2xl',
    'titleTooltip'    => null,
    'viewAllUrl'      => null,
    'viewAllClass'    => '',
    'hideNavigation'  => false,
    'hideBullets'     => false,
    'topPagination'   => false,
    'paginationClass' => '',
    'rows'            => 1,
    'columns'         => 5,
    'breakpoints'     => null,
    'spaceBetween'    => 0,
    'loop'            => false,
    'allowTouch'      => true,
    'autoplay'        => false,
    'autoplayDelay'   => 3000,
    'hideViewAll'     => false,
    'shadowSpacing'   => false,
])

@php

    $hasViewAll = $viewAllUrl && ! $hideViewAll;

    $slidesBreakpoints = extractSlidesBreakpoints($breakpoints);

    $classesPerBreakpoint = collect([
        '0' => [
            '1' => 'grid-cols-1',
            '2' => 'grid-cols-2',
            '3' => 'grid-cols-3',
            '4' => 'grid-cols-4',
        ],
        '640' => [
            '1' => 'sm:grid-cols-1',
            '2' => 'sm:grid-cols-2',
            '3' => 'sm:grid-cols-3',
        ],
        '768' => [
            '1' => 'md:grid-cols-1',
            '2' => 'md:grid-cols-2',
            '3' => 'md:grid-cols-3',
        ],
        '1024' => [
            '1' => 'lg:grid-cols-1',
            '2' => 'lg:grid-cols-2',
            '3' => 'lg:grid-cols-3',
        ],
        '1280' => [
            '1' => 'xl:grid-cols-1',
            '2' => 'xl:grid-cols-2',
            '3' => 'xl:grid-cols-3',
        ],
    ]);

    $gridClasses = $classesPerBreakpoint->map(function ($classes, $breakpoint) use ($slidesBreakpoints)  {
        $key = $slidesBreakpoints->get($breakpoint);

        if (!$key) {
            return null;
        }

        return $classes[$key];
    })->filter(fn($className) => !!$className)->join(' ');

@endphp

<div class="w-full">
    <div class="relative @unless($hideNavigation) px-10 @endunless">
        <div
            id="swiper-{{ $id }}"
            class="swiper-container
                @unless ($topPagination) slider-pagination-bottom @endunless
                @if ($hasViewAll) slider-show-view-all @endif
                @if ($shadowSpacing) px-5 @endif
                @if ($rows > 1) slider-multirow @endif"
        >
            @include('ark::includes.slider.header')

            <div
                class="@if($shadowSpacing) px-5 pt-5 -mx-5 -mt-5 @endif swiper-wrapper grid grid-cols-1 {{ $gridClasses }}"
                style="gap: {{ $spaceBetween }}px"
            >
                {{ $slot }}
            </div>

            @unless($topPagination)
                <div class="swiper-pagination {{ $paginationClass }}"></div>
            @endunless
        </div>

        @include('ark::includes.slider.navigation')
    </div>

    @include('ark::includes.slider.scripts')
</div>
