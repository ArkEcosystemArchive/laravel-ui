@props([
    'options',
    'id',
    'title' => null,
    'class' => '',
    'model' => null,
    'description' => null,
    'single' => false,
    'hiddenOptions' => false,
    'mobileShowRows' => 3,
    'withoutIcon' => false,
    'wrapperClass' => 'space-y-6',
    'gridWrapperClass' => null,
    'iconWrapper' => 'flex flex-col justify-center items-center md:space-y-2 h-full',
    'iconBreakpoints' => null,
    'optionTitleClass' => 'font-semibold',
    'withoutSelectAll' => false,
    'selectionLimit' => null,
    'selectedOptionsCount' => null,
    'selectedOptionsTooltip' => null,
    'disabledCheckboxTooltip' => null,
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
    <div class="{{ $wrapperClass }}">
        <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:justify-between {{ $description ? 'md:items-end' : 'md:items-center' }}">
            @if($title || $description)
                <div class="flex flex-col">
                    @if($title)
                        <div class="text-lg font-bold text-theme-secondary-900">
                            {{ $title }}
                        </div>
                    @endif

                    @if ($description)
                        <div>{{ $description }}</div>
                    @endif
                </div>
            @endif

            @unless ($hiddenOptions || $single === true || $withoutSelectAll)
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

            @if($withoutSelectAll && $selectionLimit)
                <label class="tile-selection-select-all">
                    <div data-tippy-content="{{ $selectedOptionsTooltip }}">{{ $selectedOptionsCount }} / {{ $selectionLimit }}</div>
                </label>
            @endif
        </div>

        @unless ($hiddenOptions)
            <div class="{{ $single ? 'tile-selection-list-single' : 'tile-selection-list' }} {{ $gridWrapperClass }}">
                @foreach ($options as $option)
                    @include('ark::inputs.includes.tile-selection-option', [
                        'option' => $option,
                        'wireModel' => $single ? ($model ?? $id) : ($model ?? $id).'.'.$option['id'].'.checked',
                        'mobileHidden' => $loop->index >= ($mobileShowRows * 2),
                        'isDisabled' => $withoutSelectAll ? ($selectedOptionsCount >= $selectionLimit) : false,
                        'disabledCheckboxTooltip' => $disabledCheckboxTooltip,
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
