@props([
    'disabled'          => false,
    'selectedClasses'   => 'text-theme-danger-400 border-theme-danger-100',
    'showMobile'        => false,
    'unselectedClasses' => 'text-theme-info-300 border-white',
])

<div @class([
    'items-center',
    'flex'           => $showMobile,
    'hidden md:flex' => ! $showMobile,
])>
    <button
        type="button"
        :class="{
            '{{ $selectedClasses }}': tableView === 'grid',
            '{{ $unselectedClasses }}': tableView !== 'grid',
        }"
        class="py-2 px-3 border-b-3"
        @if ($disabled) disabled @else @click="tableView = 'grid'" @endif
    >
        <x-ark-icon name="grid" />
    </button>

    <button
        type="button"
        :class="{
            '{{ $selectedClasses }}': tableView === 'list',
            '{{ $unselectedClasses }}': tableView !== 'list',
        }"
        class="py-2 px-3 border-b-3"
        @if ($disabled) disabled @else @click="tableView = 'list'" @endif
    >
        <x-ark-icon name="list" />
    </button>
</div>
