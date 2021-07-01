@props([
    'class'        => '',
    'message'      => null,
    'messageClass' => 'text-sm',
    'large'        => false,
    'title'        => null,
    'type'         => 'info',
])

<div {{
    $attributes->merge(['class' => $class.' alert-wrapper alert-'.$type])
        ->except([
            'large',
            'message',
            'messageClass',
            'title',
            'type',
        ])
}}>
    <div class="alert-icon-wrapper alert-{{ $type }}-icon @if($large) alert-icon-large @endif">
        <div class="p-1 rounded-full border-2 border-white">
            <x-ark-icon
                :name="alertIcon($type)"
                :size="$large ? 'md' : 'xs'"
            />
        </div>
    </div>

    <div class="alert-content-wrapper alert-{{ $type }}-content @if($large) alert-content-large @endif">
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
