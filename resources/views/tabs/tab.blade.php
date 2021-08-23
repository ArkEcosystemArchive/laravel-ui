@props(['name'])

<li role="presentation">
    <button
        type="button"
        role="tab"
        id="tab-{{ $name }}"
        :class="{ 'tab-item-current': selected === '{{ $name }}' }"
        @click="select('{{ $name }}')"
        wire:key="tab-{{ $name }}"
        @keydown="keyboard"
        :tabindex="selected === '{{ $name }}' ? 0 : -1"
        :aria-selected="selected === '{{ $name }}'"
        {{ $attributes->merge(['class' => 'tab-item']) }}
    >
        {{ $slot }}
    </button>
</li>
