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
        class="relative inline-flex items-center justify-center flex-shrink-0 w-10 h-5 cursor-pointer focus:outline-none"
        role="checkbox"
        tabindex="0"
        @click="toggle()"
        @keydown.space.prevent="toggle()"
        :aria-checked="value.toString()"
    >
        <span aria-hidden="true" class="input-toggle-slide"></span>
        <span
            aria-hidden="true"
            :class="{
                'input-switch-button-left': value,
                'input-switch-button-right': !value
            }"
            class="input-toggle-button"></span>
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
