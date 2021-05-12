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

@php ($hasViewAll = $viewAllUrl && ! $hideViewAll)

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

            <div class="@if($shadowSpacing) px-5 pt-5 -mx-5 -mt-5 @endif swiper-wrapper">
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
