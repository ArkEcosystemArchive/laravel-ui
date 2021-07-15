@props([
    'title',
    'description',
    'image' => null,
])

<meta name="description" content="{{ trim($description) }}" />

<meta property="og:title" content="{{ trim($title) }}" />
<meta property="og:description" content="{{ trim($description) }}" />

@if ($image)
    <meta property="og:image" content="{{ trim($image) }}" />
@endif
