@props([
    'showMobile'        => false,
    'selectedClasses'   => 'text-theme-danger-400 border-theme-danger-100',
    'unselectedClasses' => 'text-theme-info-300 border-white',
    'disabled'          => false,
])

<div class="items-center @if($showMobile) flex @else hidden md:flex @endif">
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
