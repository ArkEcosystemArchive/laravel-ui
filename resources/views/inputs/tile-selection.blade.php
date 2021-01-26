@props([
    'options',
    'id',
    'title',
    'class' => '',
    'model' => null,
    'description' => null,
    'single' => false,
    'hiddenOptions' => false,
    'mobileShowRows' => 3,
])

<div
    wire:key="tile-selection-{{ $id }}"
    class="space-y-4 {{ $class }}"
    x-data="{
        options: {{ json_encode(collect($options)->keyBy('id')) }},
        selectedOption: @if ($single) '{{ $this->{$model ?? $id} }}' @else null @endif,
        allSelected: false,
        mobileHidden: true,
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
    <div class="space-y-6">
        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:justify-between {{ $description ? 'md:items-end' : 'md:items-center' }}">
            <div class="flex flex-col">
                <div class="text-lg font-bold text-theme-secondary-900">
                    {{ $title }}
                </div>

                @if ($description)
                    <div>{{ $description }}</div>
                @endif
            </div>

            @unless ($hiddenOptions || $single === true)
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
            <div class="{{ $single ? 'tile-selection-list-single' : 'tile-selection-list' }}">
                @foreach ($options as $option)
                    @include('ark::inputs.tile-selection-option', [
                        'id' => $id,
                        'option' => $option,
                        'single' => $single,
                        'wireModel' => $single ? ($model ?? $id) : ($model ?? $id).'.'.$option['id'].'.checked',
                        'mobileHidden' => $loop->index >= ($mobileShowRows * 2),
                    ])
                @endforeach
            </div>
        @endunless
    </div>

    @if (! $hiddenOptions && count($options) > ($mobileShowRows * 2))
        <div
            class="py-3 font-semibold text-center rounded bg-theme-primary-100 text-theme-primary-600 sm:hidden"
            x-bind:class="{ hidden: ! mobileHidden }"
            @click="mobileHidden = false"
        >
            @lang('ui::general.show_more')
        </div>
    @endif
</div>
