@php ($route = route($route, empty($params) ? [] : $params))
@php ($isCurrent = url()->full() === $route)
<div class="flex">
    <a
        href="{{ $route }}"
        class="navbar-mobile-link @if($isCurrent) navbar-mobile-link-current @endif"
    >
        @if($icon ?? false)
            @svg($icon, 'w-6 mr-4')
        @endif

        {{ $customIcon ?? false }}

        {{ $name }}
    </a>
</div>
