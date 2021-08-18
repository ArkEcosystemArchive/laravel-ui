@props([
    'class'        => '',
    'large'        => false,
    'message'      => null,
    'messageClass' => 'text-sm',
    'title'        => null,
    'type'         => 'info',
])

<div {{
    $attributes->merge(['class' => $class.' alert-wrapper alert-'.$type])
}}>
    <div @class([
        'alert-icon-wrapper alert-'.$type.'-icon',
        'alert-icon-large' => $large
    ])>
        <div class="p-1 rounded-full border-2 border-white">
            <x-ark-icon
                :name="alertIcon($type)"
                :size="$large ? 'md' : 'xs'"
            />
        </div>
    </div>

    <div @class([
        'alert-content-wrapper alert-'.$type.'-content',
        'alert-content-large' => $large
    ])>
        @isset($title)
            <span class="alert-{{ $type }}-title">{{ $title }}</span>
        @endif

        @isset($message)
            <span class="block leading-6 {{ $messageClass }}">{{ $message }}</span>
        @else
            <span class="block {{ $messageClass }}">{{ $slot }}</span>
        @endif
    </div>
</div>