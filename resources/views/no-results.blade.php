@props([
    'text' => trans('ui::general.no-results'),
    'image' => '/images/vendor/ark/search/empty.svg',
    'imageDark' => '/images/vendor/ark/search/empty-dark.svg',
    'excludeDark' => false,
])

<div class="flex flex-col justify-center pt-8 space-y-8">
    <div class="flex justify-center">
        <img src="{{ $image }}" class="h-32 dark:hidden" />
        @if($excludeDark )
            <img src="{{ $imageDark }}" class="hidden h-32 dark:block" />
        @endif
    </div>

    <span class="text-center">{{ $text }}</span>
</div>
