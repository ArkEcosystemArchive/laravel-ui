@props([
    'title',
    'description',
    'metaTitle' => null,
    'image' => null,
])

<title>{{ $title }}</title>

<meta name="description" content="{{ trim($description) }}" />

<meta property="og:title" content="{{ trim($metaTitle ?? $title) }}" />
<meta property="og:description" content="{{ trim($description) }}" />

@if ($image)
    <meta property="og:image" content="{{ trim($image) }}" />
@endif
