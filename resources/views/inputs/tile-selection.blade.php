@props([
    'options',
    'id',
    'title',
    'class' => '',
    'model' => null,
    'description' => null,
    'compact' => false,
    'hiddenOptions' => false,
])

<div
    class="space-y-6 {{ $class }}"
    x-data="{
        options: {{ json_encode(collect($options)->keyBy('name')) }},
        allSelected: true,
        selectAll: function() {
            let checkAllValue = true;
            if (this.allSelected) {
                checkAllValue = false;
            }

            for (const optionKey in this.options) {
                this.options[optionKey].checked = checkAllValue;
            }
        }
    }"
>
    <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:justify-between md:items-end">
        <div class="flex flex-col">
            <div class="text-lg font-bold">
                {{ $title }}
            </div>

            @if ($description)
                <div>{{ $description }}</div>
            @endif
        </div>

        @unless ($hiddenOptions)
            <label class="tile-selection-select-all">
                <input
                    type="checkbox"
                    class="form-checkbox tile-selection-select-all-checkbox"
                    x-on:click="selectAll"
                    x-model="allSelected"
                />

                <div>@lang('ui::general.select-all')</div>
            </label>
        @endunless
    </div>

    @unless ($hiddenOptions)
        <div class="{{ $compact ? 'tile-selection-list-compact' : 'tile-selection-list' }}">
            @foreach ($options as $option)
                @include('ark::inputs.tile-selection-option', [
                    'id' => $id,
                    'option' => $option,
                    'compact' => $compact,
                    'wireModel' => ($model ?? $id).'.'.$option['name'].'.checked',
                ])
            @endforeach
        </div>
    @endunless
</div>
