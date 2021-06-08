@props([
    'stroke' => 'currentColor',
    'circleColor' => null,
    'size' => 'w-6 h-6',
])

<svg class="{{ $size }}" viewBox="-3 -3 43 43" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
    <g transform="translate(1 1)" stroke-width="6" fill="none" fill-rule="evenodd">
        <circle cx="18" cy="18" r="18" @if($circleColor) stroke="var(--theme-color-{{ $circleColor }})" @else stroke-opacity=".5"  @endif />
        <path d="M36 18c0-9.94-8.06-18-18-18"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"/></path>
    </g>
</svg>


