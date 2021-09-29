@props([
    'passwordRules',
    'isTyping',
    'rulesWrapperClass' => 'grid gap-4 mt-4 sm:grid-cols-2'
])

<div {{ $attributes }}>
    <div class="flex flex-1">
        {{ $slot }}
    </div>

    <div class="flex flex-col text-sm">
        <div
            class="{{ $rulesWrapperClass }}"
            x-show="isTyping"
            x-cloak
        >
            @foreach($passwordRules as $ruleName => $ruleIsValid)
                <div class="flex items-center space-x-2 min-w-1/3">
                    @if ($ruleIsValid)
                        <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 rounded-full bg-theme-success-200">
                            <x-ark-icon name="checkmark" size="2xs" style="success" />
                    @elseif(! $ruleIsValid)
                        <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 border-2 rounded-full border-theme-secondary-600">
                    @else
                        <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 rounded-full bg-theme-danger-200">
                            <x-ark-icon name="exclamation" style="danger" />
                    @endif
                        </div>

                    <span
                        class="font-semibold {{ $ruleIsValid ? 'text-theme-success-600' : 'text-theme-secondary-600' }}"
                    >
                        @lang('fortify::forms.password-rules.' .Str::snake($ruleName))
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
