@if ($title || $hasViewAll)
    <div class="flex flex-col mb-6 space-y-4 sm:space-y-0 sm:flex-row sm:items-center
        @if ($title) sm:justify-between @else sm:justify-end @endif"
    >
        @if ($title)
            <div class="slider-title {{ $titleClass }}">
                {{ $title }}

                @if ($titleTooltip)
                    <div class="inline-flex items-end">
                        <x-ark-info
                            :tooltip="$titleTooltip"
                            class="absolute -top-10 ml-1"
                            type="hint"
                            large
                        />
                    </div>
                @endif
            </div>
        @endif

        <div class="flex relative justify-between items-center space-x-6">
            @if ($topPagination)
                <div class="swiper-pagination text-right {{ $paginationClass }}"></div>
            @endif

            @if ($hasViewAll)
                <div class="leading-5">
                    <a href="{{ $viewAllUrl }}" class="font-semibold link rounded">
                        @lang('ui::actions.view_all')

                        <x-ark-icon class="inline-block" name="chevron-right" size="2xs" />
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
