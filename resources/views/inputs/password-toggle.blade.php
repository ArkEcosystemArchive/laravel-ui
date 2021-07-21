<div
    class="{{ $class ?? '' }}"
    x-data="{
        show: false,
        @if($masked ?? false)
            type: 'text',
            style: '-webkit-text-security: disc;',
            toggle() {
                this.show = !this.show;
                this.show ? this.style = '' : this.style = '-webkit-text-security: disc;';
            },
        @else
            type: 'password',
            style: '',
            toggle() {
                this.show = !this.show;
                this.show ? this.type = 'text' : this.type = 'password';
            },
        @endif
    }"
>
    <div class="input-group">
        @if(!($hideLabel ?? false))
            <label
                for="{{ $id ?? $name }}"
                class="input-label @error($name) input-label--error @enderror"
            >
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endif

        <div class="input-wrapper">
            {{--input--}}
            <input
                x-ref="password-input"
                :type="type"
                :style="style"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                class="input-text shifted @error($name) input-text--error @enderror {{ $inputClass ?? '' }}"
                wire:model="{{ $model ?? $name }}"
                @if($max ?? false) maxlength="{{ $max }}" @endif
                @if($value ?? false) value="{{ $value }}" @endif
                @if($autofocus ?? false) autofocus @endif
                @if($readonly ?? false) readonly @endif
                @if($required ?? false) required @endif
                @keydown="$dispatch('typing')"
            />

            {{--toggle--}}
            <button type="button" class="right-0 px-4 input-icon text-theme-primary-300 rounded @error($name) text-theme-danger-500 @enderror" @click="toggle()">
                <span x-show="!show">@svg('view', 'w-5 h-5')</span>
                <span x-show="show" x-cloak>@svg('hide', 'w-5 h-5')</span>
            </button>

            {{--error--}}
            @error($name)
                @include('ark::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id' => $id ?? $name,
                    'shifted' => true,
                ])
            @enderror
        </div>
    </div>
</div>
