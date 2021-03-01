@props([
    'message' => null,
    'messageClass' => 'text-sm',
    'type' => 'info',
    'large' => false,
])

<div class="alert-wrapper alert-{{ $type }} items-center">
    <div class="alert-icon-wrapper alert-{{ $type }}-icon @if($large) alert-icon-large @endif">
        <div class="flex justify-center items-center w-6 h-6 rounded-full border-2 border-white">@svg(alertIcon($type), $large ? 'h-6 w-6' : 'h-3 w-3')</div>
    </div>

    <div class="alert-content-wrapper alert-{{ $type }}-content @if($large) alert-content-large @endif">
        @isset($title)<span class="alert-{{ $type }}-title">{{ $title }}</span>@endif
        @isset($message)
            <span class="block leading-6 {{ $messageClass }}">{{ $message }}</span>
        @else
            <span class="block {{ $messageClass }}">{{ $slot }}</span>
        @endif
    </div>
</div>
