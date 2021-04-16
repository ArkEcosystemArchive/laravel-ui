@php ($route = route($route, empty($params) ? [] : $params))
@php ($isCurrent = url()->full() === $route)
<div class="flex">
    <div class="@if($isCurrent) bg-theme-primary-600 rounded-xl @endif w-2 -mr-1 z-10"></div>

    <a
        href="{{ $route }}"
        class="flex items-center block font-semibold pl-8 py-3 @if($isCurrent) text-theme-primary-600 bg-theme-primary-100 @else text-theme-secondary-900 hover:text-theme-primary-600 @endif rounded-r w-full"
        dusk='navbar-item-{{ Str::slug($name) }}'
    >
        @if($icon ?? false)
            @svg($icon, 'w-6 mr-4')
        @endif

        {{ $customIcon ?? false }}

        {{ $name }}
    </a>
</div>
