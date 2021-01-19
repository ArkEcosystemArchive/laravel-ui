@props([
    'values',
    'description' => null,
])

<div x-data="{ showDropdown: false }" x-cloak>
    <div
        class="multiple-list-link"
        @click="showDropdown = true"
        @click.away="showDropdown = false"
    >
        @lang('ui::general.multiple')
    </div>

    <div class="multiple-list-dropdown" x-bind:class="{ hidden: ! showDropdown }">
        @if ($description)
            <div class="text-theme-secondary-500">{{ $description }}</div>
        @endif

        <div class="multiple-list-grid">
            @foreach ($values as $value)
                <div class="flex items-center space-x-2">
                    <x-ark-icon name="checkmark-thin" class="text-theme-success-600" size="sm" />

                    <div>{{ $value }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
