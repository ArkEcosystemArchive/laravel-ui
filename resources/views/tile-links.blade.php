@props([
    'links',
    'id',
    'title',
    'class'          => '',
    'model'          => null,
    'description'    => null,
    'single'         => false,
    'hiddenOptions'  => false,
    'mobileShowRows' => 3,
    'isInput'        => false,
    'desktopShowCount' => count($links),
    'hideBorder'     => false,
])

<div
    wire:key="tile-links-{{ $id }}"
    class="space-y-4 {{ $class }}"
    x-data="{
        options: {{ json_encode(collect($links)->keyBy('id')) }},
        linksHidden: true,
    }"
    x-cloak
>
    <div class="space-y-6">
        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:justify-between {{ $description ? 'md:items-end' : 'md:items-center' }}">
            <div class="flex flex-col">
                <div class="text-lg font-bold text-theme-secondary-900">
                    {{ $title }}
                </div>

                @if ($description)
                    <div>{{ $description }}</div>
                @endif
            </div>
        </div>

        @unless ($hiddenOptions)
            <div class="{{ $single ? 'tile-links-list-single' : 'tile-links-list' }}">
                @foreach ($links as $option)
                    @include('ark::tile-link', [
                        'id'     => $id,
                        'option' => $option,
                        'index'  => $loop->index,
                    ])
                @endforeach

                <div
                    x-show="linksHidden"
                    class="hidden tile-links-show-more sm:block"
                    @click="linksHidden = false"
                >
                    <div class="flex flex-col justify-center items-center space-y-2 h-full">
                        <div>
                            <div class="sm:hidden">+{{ count($links) - 7 }}</div>
                            <div class="hidden sm:block md:hidden">+{{ count($links) - 8 }}</div>
                            <div class="hidden md:block lg:hidden">+{{ count($links) - 7 }}</div>
                            <div class="hidden lg:block xl:hidden">+{{ count($links) - 9 }}</div>
                            <div class="hidden xl:block">+{{ count($links) - 11 }}</div>
                        </div>

                        <div>@lang('ui::general.show_more')</div>
                    </div>
                </div>

                <div
                    x-show="! linksHidden"
                    class="hidden tile-links-show-more sm:block"
                    @click="linksHidden = true"
                >
                    <div class="flex flex-col justify-center items-center space-y-2 h-full">
                        <x-ark-icon name="hide" size="md" />

                        <div>@lang('ui::general.hide')</div>
                    </div>
                </div>
            </div>
        @endunless
    </div>
</div>
