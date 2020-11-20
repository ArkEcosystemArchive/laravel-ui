<div class="flex items-center">
    <div
        :class="{
            'text-theme-danger-400 border-theme-danger-100': tableView === 'grid',
            'text-theme-info-300 border-white': tableView !== 'grid',
        }"
        class="px-3 py-2 cursor-pointer text-theme-info-300 border-b-3"
        @click="tableView = 'grid'"
    >
        <x-ark-icon name="grid" />
    </div>

    <div
        :class="{
            'text-theme-danger-400 border-theme-danger-100': tableView === 'list',
            'text-theme-info-300 border-white': tableView !== 'list',
        }"
        class="px-3 py-2 cursor-pointer text-theme-info-300 border-b-3"
        @click="tableView = 'list'"
    >
        <x-ark-icon name="list" />
    </div>
</div>
