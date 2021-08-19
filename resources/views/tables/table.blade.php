@props([
    'noContainer' => false,
    'sticky'      => false,
    'tableClass'  => '',
])

@unless ($noContainer)
    <div {{ $attributes->merge(['class' => 'table-container']) }}>
@endunless
    <table class="{{ $tableClass . ($sticky ? ' sticky-headers' : '') }}">
        {{ $slot }}
    </table>
@unless ($noContainer)
    </div>
@endunless
