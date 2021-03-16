@props([
    'total',
    'triggerDusk' => null,
    'triggerClass' => '',
    'collapsedClass' => '',
    'expandedClass' => '',
    'collapsed' => null,
    'expanded' => null,
    'placeholder' => null,
    'placeholderCount' => 1,
    'showMore' => null,
    'style' => '',
])

<ol data-expandable
    x-data="{ expanded: false }"
    :class="{ 'show-all': expanded }"
    style="--expandable-total-count: {{ $total }};{{ $style }}"
    x-init="$watch('expanded', (expanded) => {
        if (expanded) {
            $nextTick(() => {
                $el.querySelectorAll('img[onload]').forEach(img => {
                    img.onload();
                    img.removeAttribute('onload');
                });
            })
        }
    })"
    {{ $attributes }}
>
    {{ $slot }}

    @isset ($placeholder)
        @for ($i = 0; $i < $placeholderCount; $i++)
            <li data-placeholder wire:key="expandable-placeholder-{{ Str::random(6) }}">
                {{ $placeholder }}
            </li>
        @endfor
    @endisset

    @isset($showMore)
        {{ $showMore }}
    @endisset

    @empty($showMore)
        <button
            data-trigger class="{{ $triggerClass }}"
            @click="expanded = !expanded"
            @isset($triggerDusk)
                dusk="{{ $triggerDusk }}"
            @endisset
        >
            <span data-collapsed class="{{ $collapsedClass }}" x-show="!expanded">
                {{ $collapsed }}
            </span>

            <span data-expanded class="{{ $expandedClass }}" x-show="expanded" x-cloak>
                {{ $expanded }}
            </span>
        </button>
    @endempty
</ol>
