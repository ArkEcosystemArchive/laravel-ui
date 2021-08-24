@props([
    'title',
    'description',
    'image' => null,
])

<meta name="description" content="{!! trim(htmlentities($description)) !!}" />

<meta property="og:title" content="{!! trim(htmlentities($title)) !!}" />
<meta property="og:description" content="{!! trim(htmlentities($description)) !!}" />

@if ($image)
    <meta property="og:image" content="{!! trim($image) !!}" />
@endif
