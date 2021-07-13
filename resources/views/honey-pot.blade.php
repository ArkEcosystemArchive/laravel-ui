@if (in_array(\Lukeraymonddowning\Honey\Checks\JavascriptInputFilledCheck::class, config('honey.checks')))
    @once
        <script>
            window.addEventListener('load', () => {
                setTimeout(() => {
                    document.querySelectorAll('input[data-purpose="{{ $inputNameSelector->getJavascriptInputName() }}"]')
                        .forEach(input => {
                            if (input.value.length > 0) {
                                return;
                            }
                            input.value = "{{ $javascriptValue() }}";
                            input.dispatchEvent(new Event('change'));
                        });
                }, {{ $javascriptTimeout() }})
            });
        </script>
    @endonce
@endif

<div style="display: @isset($attributes['debug']) block @else none @endisset;">
    <input wire:model.lazy.defer="honeyInputs.{{ $inputNameSelector->getPresentButEmptyInputName() }}" name="{{ $inputNameSelector->getPresentButEmptyInputName() }}" value="">
    <input wire:model.lazy.defer="honeyInputs.{{ $inputNameSelector->getTimeOfPageLoadInputName() }}" name="{{ $inputNameSelector->getTimeOfPageLoadInputName() }}" value="{{ $timeOfPageLoadValue() }}">
    <input wire:model.lazy.defer="honeyInputs.{{ $inputNameSelector->getJavascriptInputName() }}" data-purpose="{{ $inputNameSelector->getJavascriptInputName() }}" name="{{ $inputNameSelector->getJavascriptInputName() }}" value="">
    {{ $slot }}
</div>

@isset($attributes['recaptcha'])
    <x-honey-recaptcha :action="$attributes['recaptcha'] === true ? 'submit' : $attributes['recaptcha']"/>
@endisset