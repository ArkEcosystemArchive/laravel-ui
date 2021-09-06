<div
    x-data="{ value: {{ $default ?? 'false' }}, toggle() { this.value = !this.value; this.$refs['checkbox-livewire'].click(); }, focused: false }"
    class="flex items-center space-x-3"
>
    <span class="font-semibold {{ $labelClass ?? '' }}" :class="{ 'text-theme-secondary-500': !value }">
        {{ $leftLabel }}
    </span>

    <span
        @focus="focused = true"
        @blur="focused = false"
        class="inline-flex relative flex-shrink-0 justify-center items-center w-8 h-5 cursor-pointer focus:outline-none focus-visible:rounded focus-visible:ring-2 focus-visible:ring-theme-primary-500"
        role="checkbox"
        tabindex="0"
        @click="toggle()"
        @keydown.space.prevent="toggle()"
        :aria-checked="value.toString()"
    >
        <span
            aria-hidden="true"
            class="absolute mx-auto w-full h-1.5 rounded-full transition-colors duration-200 ease-in-out bg-theme-secondary-300 dark:bg-theme-secondary-800"
        ></span>
        <span
            aria-hidden="true"
            :class="{
                'input-switch-button-left': !value,
                'input-switch-button-right': value
            }"
            class="inline-block absolute left-0 w-4 h-4 bg-white rounded-full transition duration-200 ease-in-out transform cursor-pointer"
        ></span>
    </span>
    <input
        x-ref="checkbox-livewire"
        type="checkbox"
        name="{{ $name }}"
        class="hidden"
        wire:model="{{ $model ?? $name }}"
        @if($alpineClick ?? false) x-on:click="{{ $alpineClick }}" @endif
        @if($default ?? false) checked @endif
    />

    <span class="font-semibold {{ $labelClass ?? '' }}" :class="{ 'text-theme-secondary-500': value }">
        {{ $rightLabel }}
    </span>
</div>
