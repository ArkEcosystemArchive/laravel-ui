@props([
    'title',
    'description',
    'image' => null,
])

<title>{{ $title }}</title>

<meta name="description" content="{{ $description }}" />

<meta property="og:title" content="{{ $metaTitle ?? $title }}" />

<meta property="og:description" content="{{ $description }}" />

@if ($image)
    <meta property="og:image" content="{{ $image }}" />
@endif
