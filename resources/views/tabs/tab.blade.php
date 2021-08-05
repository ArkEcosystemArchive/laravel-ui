@props(['name'])

<button
    type="button"
    class="tab-item transition-default"
    :class="{ 'tab-item-current': selected === '{{ $name }}' }"
    @click="select('{{ $name }}')"
    @keydown.enter="select('{{ $name }}')"
    @keydown.space.prevent="select('{{ $name }}')"
    role="tab"
    id="tab-{{ $name }}"
    {{--aria-controls="panel-{{ $name }}"--}}
    wire:key="tab-{{ $name }}"
    @keydown.arrow-left="selectPrevTab"
    @keydown.arrow-right="selectNextTab"
    :tabindex="selected === '{{ $name }}' ? 0 : -1"
    :aria-selected="selected === '{{ $name }}'"
    {{ $attributes }}
>
    {{ $slot }}
</button>

