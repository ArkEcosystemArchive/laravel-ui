@props([
    'links',
    'id',
    'class'       => '',
    'title'       => '',
    'model'       => null,
    'description' => null,
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
        @if ($title || $description)
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:justify-between">
                <div class="flex flex-col">
                    @if ($title)
                        <div class="text-lg font-bold text-theme-secondary-900">
                            {{ $title }}
                        </div>
                    @endif

                    @if ($description)
                        <div>{{ $description }}</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="tile-links-list">
            @foreach ($links as $link)
                @include('ark::tile-link', [
                    'id'    => $id,
                    'link'  => $link,
                    'index' => $loop->index,
                ])
            @endforeach

            <div
                x-show="linksHidden"
                class="tile-links-show-more hidden sm:block"
                @click="linksHidden = false"
            >
                <div class="flex flex-col justify-center items-center h-full space-y-2">
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
                class="tile-links-show-more hidden sm:block"
                @click="linksHidden = true"
            >
                <div class="flex flex-col justify-center items-center h-full space-y-2">
                    <x-ark-icon name="hide" size="md" />

                    <div>@lang('ui::general.hide')</div>
                </div>
            </div>
        </div>
    </div>
</div>
