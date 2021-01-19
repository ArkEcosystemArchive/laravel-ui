@props([
    'values',
    'description' => null,
])

<div x-data="{ showDropdown: false }">
    <div
        class="multiple-list-link"
        @click="showDropdown = true"
        @click.away="showDropdown = false"
    >
        @lang('ui::general.multiple')
    </div>

    <div class="absolute rounded-lg bg-white shadow-xl font-semibold p-8 mt-4 space-y-6" x-bind:class="{ hidden: ! showDropdown }">
        @if ($description)
            <div class="text-theme-secondary-500">{{ $description }}</div>
        @endif

        <div class="grid grid-cols-4 gap-x-8 gap-y-4">
            @foreach ($values as $value)
                <div class="flex space-x-2 items-center">
                    <x-ark-icon name="checkmark-thin" class="text-theme-success-600" size="sm" />

                    <div>{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
