@props(['name'])

<div role="tabpanel" id="tab-panel-{{ $name }}" x-show="selected === '{{ $name }}'" {{ $attributes->merge(['class' => 'tab-panel']) }}>
    {{ $slot }}
</div>
