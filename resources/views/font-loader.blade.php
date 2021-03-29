@props(['src', 'preconnect' => null])

@php
    $preconnect = $preconnect ?? $src;

    if (preg_match('|google|', $src) && ! preg_match('|display=swap|', $src)) {
        $src .= '&display=swap';
    }
@endphp

<link rel="preconnect" href="{!! $preconnect !!}" crossorigin />
<link rel="preload" as="style" href="{!! $src !!}" />
<link rel="stylesheet" href="{!! $src !!}" media="print" onload="this.media='all'" />
<noscript><link rel="stylesheet" href="{!! $src !!}" /></noscript>
