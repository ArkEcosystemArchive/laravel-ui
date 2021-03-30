@props([
    'text' => trans('ui::general.no-results'),
])

<div class="flex flex-col justify-center pt-8 space-y-8">
    <div class="flex justify-center">
        <img src="/images/vendor/ark/search/empty.svg" class="h-32 dark:hidden" />
        @if($excludeDark ?? false)
            <img src="/images/vendor/ark/search/empty-dark.svg" class="hidden h-32 dark:block" />
        @endif
    </div>

    <span class="text-center">{{ $text }}</span>
</div>
