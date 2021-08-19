@props([
    'id',
    'model',
    'name',
    'autofocus'  => false,
    'class'      => null,
    'hideLabel'  => false,
    'inputClass' => '',
    'label'      => trans('forms' . $name),
    'masked'     => false,
    'max'        => null,
    'message'    => null,
    'readonly'   => false,
    'required'   => false,
    'value'      => null,
])

<div
    class="{{ $class }}"
    x-data="{
        show: false,
        @if($masked)
            type: 'text',
            style: '-webkit-text-security: disc;',
            toggle() {
                this.show = !this.show;
                this.show ? this.style = '' : this.style = '-webkit-text-security: disc;';
            },
        @else
            type: 'password',
            toggle() {
                this.show = !this.show;
                this.show ? this.type = 'text' : this.type = 'password';
            },
        @endif
    }"
>
    <div class="input-group">
        @if(! ($hideLabel))
            <label
                for="{{ $id ?? $name }}"
                class="input-label @error($name) input-label--error @enderror"
            >
                {{ $label }}
            </label>
        @endif

        <div class="input-wrapper">
            {{--input--}}
            <input
                x-ref="password-input"
                :type="type"
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                class="input-text shifted @error($name) input-text--error @enderror {{ $inputClass }}"
                wire:model="{{ $model ?? $name }}"
                @if($masked) :style="style" @endif
                @if($max) maxlength="{{ $max }}" @endif
                @if($value) value="{{ $value }}" @endif
                @if($autofocus) autofocus @endif
                @if($readonly) readonly @endif
                @if($required) required @endif
                @keydown="$dispatch('typing')"
            />

            {{--toggle--}}
            <button
                type="button"
                class="right-0 px-4 input-icon text-theme-primary-300 rounded @error($name) text-theme-danger-500 @enderror"
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
