@props([
    'options',
    'initialValue' => null,
    'dispatchEvent' => null,
    'buttonClass' => 'inline-block w-full px-4 py-3 text-left form-input transition-default dark:bg-theme-secondary-900 dark:border-theme-secondary-800',
    'wrapperClass' => 'w-full',
    'dropdownClass' => 'mt-1',
    'iconClass' => 'absolute inset-y-0 right-0 flex items-center justify-center mr-4',
    'placeholder' => '',
    'grouped' => false,
])

@php
if ($initialValue) {
    $initialText = $grouped
        ? collect($options)->flatMap(fn ($value) => $value)->get($initialValue)
        : collect($options)->get($initialValue);
}
@endphp

<div
    class="relative {{ $wrapperClass }}"
    x-data="{
        options: {{ json_encode($options) }},
        onInput($dispatch, $event) {
            @isset($dispatchEvent)
            $dispatch('{{$dispatchEvent}}', $event.target.value)
            @endisset
        },
        init: function() {
            this.$nextTick(() => {
                @if($grouped)
                this.optionsCount = Object.keys(this.options).map(groupName => {
                    return Object.keys(this.options[groupName])
                }).flat().length;
                @else
                this.optionsCount = Object.keys(this.options).length;
                @endif
            });
        },
        optionsCount: null,
        open: false,
        selected: null,
        selectedGroup: null,
        @isset($initialValue)
        value: '{{ $initialValue }}',
        @else
        value: null,
        @endif
        @isset($initialText)
        text: '{{ $initialText }}',
        @else
        text: null,
        @endif
        choose: function(value, groupName = null) {
            if (this.value === value) {
                return;
            }

            this.value = value;

            this.text = groupName !==null
                ? this.options[groupName][value]
                : this.options[value];

            this.open = false;

            this.setHiddenInputValue(value);
        },
        choose: function(value, groupName = null) {
            if (this.value === value) {
                return;
            }

            this.value = value;

            this.text = groupName !==null
                ? this.options[groupName][value]
                : this.options[value];

            this.open = false;

            this.setHiddenInputValue(value);
        },
        setHiddenInputValue: function(value, dispatchEvent = true) {
            console.log('setHiddenInputValue', value)
            const { input } = this.$refs;

            input.value = value

            if (!dispatchEvent) {
                return;
            }

            const event = new Event('input', {
                bubbles: true,
                cancelable: true,
            });

            input.dispatchEvent(event);
        },
        onButtonClick: function() {
            const { listbox } = this.$refs;
            @if($grouped)
            const selectedIndex = this.getAllValues().indexOf(this.value);
            @else
            const selectedIndex = Object.keys(this.options).indexOf(this.value);
            @endif
            this.selected = selectedIndex >= 0 ? selectedIndex : 0;
            this.open = true;
            this.$nextTick(() => {
                listbox.focus();
                this.scrollToSelectedOption();
            })
        },
        onOptionSelect: function() {
            @if($grouped)
            const allValues = this.getAllValues();
            this.choose(allValues[this.selected], this.selectedGroup)
            @else
            if (null !== this.selected) {
                this.choose(Object.keys(this.options)[this.selected])
            }
            @endif
            this.open = false;
            this.$refs.button.focus();
        },
        onEscape: function() {
            this.open = false;
            this.$refs.button.focus();
        },
        onArrowUp: function() {
            this.selected = this.selected - 1 < 0 ? this.optionsCount - 1 : this.selected - 1;
            this.scrollToSelectedOption();
        },
        onArrowDown: function() {
            this.selected = this.selected + 1 > this.optionsCount - 1 ? 1 : this.selected + 1;
            this.scrollToSelectedOption();
        },
        scrollToSelectedOption: function () {
            const { listbox } = this.$refs;
            const option = listbox.querySelectorAll('[data-option]')[this.selected]
            @if($grouped)
            this.selectedGroup  = option.dataset.group;
            @endif
            option.scrollIntoView({
                block: 'nearest'
            });
        },
        getAllValues: function() {
            return Object.keys(this.options).map(groupName => {
                return Object.keys(this.options[groupName])
            }).flat();
        },
        getOptionIndex: function(groupIndex, optionIndex) {
            let index = 0;
            for (var i = 0; i < groupIndex; i++) {
                const group = this.options[Object.keys(this.options)[i]]
                index += Object.keys(group).length;
            }
            return index + optionIndex;
        },
    }"
    x-init="init()"
>
    <input x-ref="input" {{ $attributes }} type="hidden" @input="onInput($dispatch, $event)" @isset($initialValue) value="{{ $initialValue }}" @endisset />

    <button
        x-ref="button"
        @keydown.arrow-up.stop.prevent="onButtonClick()"
        @keydown.arrow-down.stop.prevent="onButtonClick()"
        @click="onButtonClick()"
        type="button"
        aria-haspopup="listbox"
        :aria-expanded="open"
        aria-labelledby="listbox-label"
        class="relative pr-10 {{ $buttonClass }}"
    >
        @isset($dropdownEntry)
            {{ $dropdownEntry }}
        @else
        <span x-show="text" x-text="text" class="block truncate dark:text-theme-secondary-300"></span>
        <span x-show="!text" class="block truncate text-theme-secondary-500 dark:text-theme-secondary-700">@if(isset($placeholder) && $placeholder) {{ $placeholder }} @else &nbsp; @endif</span>
        @endif

        <span
            class="{{ $iconClass }} transition duration-150 transform pointer-events-none"
            :class="{ 'rotate-180': open }"
        >
            <x-ark-icon
                name="chevron-down"
                size="2xs"
            />
        </span>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute w-full min-w-max-content {{ $dropdownClass }}"
        style="display: none;"
    >
        <div
            @keydown.enter.stop.prevent="onOptionSelect()"
            @keydown.space.stop.prevent="onOptionSelect()"
            @keydown.escape="onEscape()"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            class="py-3 overflow-auto bg-white rounded-md shadow-xs outline-none dark:bg-theme-secondary-800 dark:text-theme-secondary-200 hover:outline-none max-h-80"
        >
            @isset($dropdownList)
                {{ $dropdownList }}
            @else
                @if(!$grouped)
                <template x-for="(optionValue, index) in Object.keys(options)" :key="optionValue">
                    <div
                        data-option
                        x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        :id="`listbox-option-${optionValue}`"
                        role="option"
                        @click="choose(optionValue)"
                        @mouseenter="selected = index"
                        @mouseleave="selected = null"
                        :class="{
                            'text-theme-danger-400 bg-theme-danger-100 dark:text-white dark:bg-theme-danger-400': value === optionValue,
                            'text-theme-primary-600 bg-theme-secondary-100 dark:bg-theme-primary-600 dark:text-white': selected === index && value !== optionValue,
                        }"
                        class="px-8 py-4 font-medium transition duration-150 ease-in-out cursor-pointer text-theme-secondary-900 hover:bg-theme-secondary-100 hover:text-theme-secondary-900 dark:text-theme-secondary-200 dark:hover:bg-theme-primary-600 dark:hover:text-theme-secondary-200"
                        x-text="options[optionValue]"
                    ></div>
                </template>
                @else
                <template x-for="(groupName, index) in Object.keys(options)" :key="index">
                    <div>
                        <span x-show="groupName" class="flex items-center w-full px-8 pt-8 text-sm font-bold leading-5 text-left text-theme-secondary-500" x-text="groupName"></span>

                        <template x-for="(optionValue, index2) in Object.keys(options[groupName])" :key="`${index}-${index2}`">
                            <div
                                data-option
                                :data-group="groupName"
                                x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                                x-state:on="Highlighted"
                                x-state:off="Not Highlighted"
                                :id="`listbox-option-${optionValue}`"
                                role="option"
                                @click="choose(optionValue, groupName)"
                                @mouseenter="selected = getOptionIndex(index, index2); selectedGroup = groupName"
                                @mouseleave="selected = null; selectedGroup = null"
                                :class="{
                                    'text-theme-danger-400 bg-theme-danger-100 dark:text-white dark:bg-theme-danger-400': value === optionValue,
                                    'text-theme-primary-600 bg-theme-secondary-100 dark:bg-theme-primary-600 dark:text-white': selected === getOptionIndex(index, index2) && value !== optionValue,
                                }"
                                class="px-8 py-4 font-medium transition duration-150 ease-in-out cursor-pointer text-theme-secondary-900 hover:bg-theme-secondary-100 hover:text-theme-secondary-900 dark:text-theme-secondary-200 dark:hover:bg-theme-primary-600 dark:hover:text-theme-secondary-200"
                                x-text="options[groupName][optionValue]"
                            ></div>
                        </template>

                        <hr x-show="index < Object.keys(options).length - 1" class="mx-8 mt-4 border-b border-dashed border-theme-secondary-300" />
                    </div>
                </template>
                @endif
            @endif
        </div>
    </div>
</div>
