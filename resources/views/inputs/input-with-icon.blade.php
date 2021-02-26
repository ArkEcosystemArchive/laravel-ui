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

        <div class="flex input-wrapper-with-icon {{ $containerClass ?? '' }}">
            <div class="flex-1">
                @include('ark::inputs.includes.input-field', [
                    'name'           => $name,
                    'errors'         => $errors,
                    'id'             => $id ?? $name,
                    'inputTypeClass' => 'input-text-with-icon',
                    'errorClass'     => 'input-text-with-icon--error',
                    'inputClass'     => $inputClass ?? '',
                    'noModel'        => $noModel ?? false,
                    'model'          => $model ?? $name,
                    'keydownEnter'   => $keydownEnter ?? null,
                    'max'            => $max ?? null,
                ])
            </div>

            @if ($slot ?? false)
                <div>
                    <div class="flex {{ $slotClass ?? 'h-full bg-white' }}">
                        {{ $slot }}
                    </div>
                </div>
            @endif
        </div>

        @include('ark::inputs.includes.input-error')
    </div>
</div>
