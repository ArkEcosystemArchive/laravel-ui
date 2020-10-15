@if (flash()->message)
    <x-ark-alert :type="flash()->class" :message="flash()->message" />
@endif
