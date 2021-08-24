@props(['name'])

<section
    role="tabpanel"
    id="tab-panel-{{ $name }}"
    aria-labelledby="tab-{{ $name }}"
    x-show="selected === '{{ $name }}'"
    {{ $attributes->merge(['class' => 'tab-panel']) }}
>
    {{ $slot }}
</section>
