<div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
    <x-ark-navbar-hamburger />

    @isset($dropdownContent)
        {{ $dropdownContent }}
    @else
        @include('ark::navbar.dropdown.content')
    @endisset
</div>
