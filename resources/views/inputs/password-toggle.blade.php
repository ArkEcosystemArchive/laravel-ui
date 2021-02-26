<div x-data="{ show: false, toggle() { this.show = !this.show; this.show ? this.$refs['password-input'].type = 'text' : this.$refs['password-input'].type = 'password'; } }" class="{{ $class ?? '' }}">
    <div class="input-group">
        @if(!($hideLabel ?? false))
            <label for="{{ $id ?? $name }}" class="input-label @error($name) input-label--error @enderror">
                {{ ($label ?? '') ? $label : trans('forms.' . $name) }}
            </label>
        @endif

        <div class="input-wrapper">
            <div class="flex space-x-4">
                <div class="flex-1">
                    <input
                        x-ref="password-input"
                        x-bind:type="show ? 'text' : 'password'"
                        id="{{ $id ?? $name }}"
                        name="{{ $name }}"
                        class="input-text @error($name) input-text--error @enderror {{ $inputClass ?? '' }}"
                        wire:model="{{ $model ?? $name }}"
                        @if($max ?? false) maxlength="{{ $max }}" @endif
                        @if($value ?? false) value="{{ $value }}" @endif
                        @if($autofocus ?? false) autofocus @endif
                        @if($readonly ?? false) readonly @endif
                        @if($required ?? false) required @endif
                    />
                </div>
                <div>
                    <button type="button" class="w-12 h-12 button-icon" @click="toggle()">
                        <span x-show="!show">@svg('view', 'w-6 h-6')</span>
                        <span x-show="show" x-cloak>@svg('hide', 'w-6 h-6')</span>
                    </button>
                </div>
            </div>
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>
