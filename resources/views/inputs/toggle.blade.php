<div
    x-data="{ focused: false, value: {{ $default ?? 'false' }}, toggle() { this.value = !this.value; this.$refs['checkbox-livewire'].click(); } }"
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
        class="relative inline-flex items-center justify-center flex-shrink-0 w-8 h-5 outline-none ring-0"
        role="checkbox"
        @focus="focused=true"
        @blur="focused=false"
        :aria-checked="value.toString()"
        tabindex="0"
        @click.prevent="toggle"
        @keyup.space.prevent="toggle"
    >
        <span aria-hidden="true" class="absolute w-full h-1.5 mx-auto transition-colors duration-200 ease-in-out rounded-full bg-theme-secondary-300 dark:bg-theme-secondary-800"></span>
        <span
            aria-hidden="true"
            :class="{
                'ring ring-focus outline-none': focused,
                'translate-x-full bg-theme-primary-600': value,
                'translate-x-0 bg-theme-secondary-300 dark:bg-theme-secondary-700': !value,
            }"
            class="absolute left-0 inline-block w-4 h-4 transition duration-200 ease-in-out transform bg-white rounded-full cursor-pointer"
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
</div>
