@props([
    'wrapperClass' => 'bg-theme-secondary-100',
    'innerWrapperClass' => 'flex flex-col items-center py-8 text-center content-container lg:space-x-16'
])

<div class="{{ $wrapperClass }}">
    <div class="{{ $innerWrapperClass }}">
        <h1>@lang('ui::pages.contact.title')</h1>
        <div class="mt-2 text-lg font-semibold">@lang('ui::pages.contact.subtitle')</div>
    </div>
</div>
