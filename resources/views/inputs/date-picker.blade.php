<input
    x-data
    x-ref="input"
    x-init="new Pikaday({
        field: $refs.input,
        format: 'DD.MM.YYYY',
        minDate: {{ $minDate ?? 0 }},
        maxDate: {{ $maxDate ?? 'new Date()' }},
        toString(date, format) {
            return date.toLocaleDateString('fi-FI', { year: 'numeric', month: '2-digit', day: '2-digit' });
        },
    })"
    type="text"
    onchange="this.dispatchEvent(new InputEvent('input'))"
    {{ $attributes }}
>
