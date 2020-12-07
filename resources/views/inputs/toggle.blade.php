<div
    x-data="{ value: {{ $default ?? 'false' }}, toggle() { this.value = !this.value; this.$refs['checkbox-livewire'].click(); }, focused: false }"
    class="flex items-center"
>
    @unless($hideLabel ?? false)
        <label for="{{ $name }}" class="input-label--toggle {{ $labelClass ?? '' }}">
            {{ ($label ?? '') ? $label : trans('forms.' . $name) }}

            @if($description ?? false)
                <div class="font-normal text-theme-secondary-500">
                    {{ $description }}
                </div>
            @endif
        </label>
    @endunless

    <span
        @focus="focused = true"
        @blur="focused = false"
        class="inline-flex relative flex-shrink-0 justify-center items-center w-10 h-5 cursor-pointer focus:outline-none"
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
                'input-toggle-button-active': value,
                'input-toggle-button-inactive': !value
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
</div>
