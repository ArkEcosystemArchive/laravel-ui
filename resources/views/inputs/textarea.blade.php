<div class="{{ $class ?? '' }}">
    <div class="input-group">
        @unless ($hideLabel ?? false)
            @include('ark::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id ?? $name,
                'label'    => $label ?? null,
                'tooltip'  => $tooltip ?? null,
                'required' => $required ?? false,
            ])
        @endunless

        <div class="input-wrapper">
            <textarea
                id="{{ $id ?? $name }}"
                name="{{ $name }}"
                rows="{{ $rows ?? '10' }}"
                class="input-text @error($name) input-text--error @enderror"
                wire:model="{{ $model ?? $name }}"
                @if($placeholder ?? '') placeholder="{{ $placeholder }}" @endif
                @if($readonly ?? '') readonly @endif
                @if($required ?? false) required @endif
                @if($maxlength ?? false) maxlength="{{ $maxlength }}" @endif
            >{{ $slot ?? '' }}</textarea>
        </div>

        @error($name)
            <p class="input-help--error">{{ $message }}</p>
        @enderror
    </div>
</div>
