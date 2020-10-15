<div>
    @if($message)
        <x-ark-alert :type="$this->alertType()">
            <x-slot name='message'>
                {!! $message !!}
            </x-slot>
        </x-ark-alert>
    @endif
</div>
