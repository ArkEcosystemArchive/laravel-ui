<div
    class="{{ $class ?? '' }}"
    x-data="{
        show: false,
        type: 'password',
        toggle() {
            this.show = !this.show;
            this.show ? this.type = 'text' : this.type = 'password';
        },
    }"
>
    <div class="input-group">
        @if(!($hideLabel ?? false))
            <label
                for="{{ $id ?? $name }}"
                @class([
                    'input-label',
                    'input-label--error' => $errors->has($name),
                ])
            >
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endif

        <div class="input-wrapper">
            {{--input--}}
            <input
                x-ref="password-input"
                :type="type"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                @class([
                    $inputClass ?? '',
                    'input-text shifted',
                    'input-text--error' => $errors->has($name),
                ])
                wire:model="{{ $model ?? $name }}"
                @if($max ?? false) maxlength="{{ $max }}" @endif
                @if($value ?? false) value="{{ $value }}" @endif
                @if($autofocus ?? false) autofocus @endif
                @if($readonly ?? false) readonly @endif
                @if($required ?? false) required @endif
                autocomplete="{{ $autocomplete ?? 'current-password' }}"
                @keydown="$dispatch('typing')"
            />

            {{--toggle--}}
            <button
                type="button"
                @class([
                    'right-0 px-4 input-icon text-theme-primary-300 rounded',
                    'text-theme-danger-500' => $errors->has($name),
                ])
                @click="toggle()"
            >
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
