@props([
    'selectedClasses'   => 'text-theme-danger-400 border-theme-danger-100',
    'unselectedClasses' => 'text-theme-info-300 border-white',
])

<div class="items-center @if($showMobile ?? false) flex @else hidden md:flex @endif">
    <div
        :class="{
            '{{ $selectedClasses }}': tableView === 'grid',
            '{{ $unselectedClasses }}': tableView !== 'grid',
        }"
        class="py-2 px-3 cursor-pointer border-b-3"
        @click="tableView = 'grid'"
    >
        <x-ark-icon name="grid" />
    </div>

    <div
        :class="{
            '{{ $selectedClasses }}': tableView === 'list',
            '{{ $unselectedClasses }}': tableView !== 'list',
        }"
        class="py-2 px-3 cursor-pointer border-b-3"
        @click="tableView = 'list'"
    >
        <x-ark-icon name="list" />
    </div>
</div>
