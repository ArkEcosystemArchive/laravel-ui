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

    <div class="absolute p-8 mt-4 space-y-6 font-semibold bg-white rounded-lg shadow-xl" x-bind:class="{ hidden: ! showDropdown }">
        @if ($description)
            <div class="text-theme-secondary-500">{{ $description }}</div>
        @endif

        <div class="grid grid-cols-4 gap-y-4 gap-x-8">
            @foreach ($values as $value)
                <div class="flex items-center space-x-2">
                    <x-ark-icon name="checkmark-thin" class="text-theme-success-600" size="sm" />

                    <div>{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
