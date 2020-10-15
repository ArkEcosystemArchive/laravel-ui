<div class="alert-wrapper alert-{{ $type }}">
    <div class="alert-icon-wrapper alert-{{ $type }}-icon @if($large ?? false) alert-icon-large @endif">
        @svg(in_array($type, ['success', 'error', 'danger', 'hint', 'warning', 'info']) ? 'alert-'.$type : 'alert-default', $large ?? '' ? 'h-10 w-10' : 'h-8 w-8')
    </div>

    <div class="alert-content-wrapper alert-{{ $type }}-content @if($large ?? false) alert-content-large @endif">
        @isset($title)<span class="alert-{{ $type }}-title">{{ $title }}</span>@endif
        @isset($message)
            <span class="block">{{ $message }}</span>
        @else
            <span class="block">{{ $slot }}</span>
        @endif
    </div>
</div>
