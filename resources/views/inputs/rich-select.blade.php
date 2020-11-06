@props([
    'options',
    'initialValue' => null,
    'dispatchEvent' => null,
    'buttonClass' => 'inline-block w-full px-4 py-3 text-left form-input transition-default dark:bg-theme-secondary-900 dark:border-theme-secondary-800',
    'wrapperClass' => 'w-full',
    'iconClass' => 'absolute inset-y-0 right-0 flex items-center justify-center mr-4',
    'placeholder' => '',
])

<div
    class="relative {{ $wrapperClass }}"
    x-data="{
        options: {{ json_encode($options) }},
        onInput($dispatch) {
            @isset($dispatchEvent)
            $dispatch('{{$dispatchEvent}}', this.value)
            @endisset
        },
        init: function() {
            this.$nextTick(() => {
                this.optionsCount = this.$refs.listbox.children.length;
            });
        },
        optionsCount: null,
        open: false,
        selected: 1,
        value: @isset($initialValue) '{{ $initialValue }}' @else null @endif,
        choose: function(value) {
            this.value = value;
            this.open = false;

            const { input } = this.$refs;
            input.value = value

            const event = new Event('input', {
                bubbles: true,
                cancelable: true,
            });

            input.dispatchEvent(event);
        },
        onButtonClick: function() {
            const { listbox } = this.$refs;
            const selectedIndex = Object.keys(this.options).indexOf(this.value);
            this.selected = selectedIndex >= 0 ? selectedIndex : 0;
            this.open = true;
            this.$nextTick(() => {
                listbox.focus();
                listbox.children[this.selected].scrollIntoView({
                    block: 'nearest'
                });
            })
        },
        onOptionSelect: function() {
            if (null !== this.selected) {
                this.choose(Object.keys(this.options)[this.selected])
            }
            this.open = false;
            this.$refs.button.focus();
        },
        onEscape: function() {
            this.open = false;
            this.$refs.button.focus();
        },
        onArrowUp: function() {
            const { listbox } = this.$refs;
            this.selected = this.selected - 1 < 0 ? this.optionsCount - 1 : this.selected - 1;
            listbox.children[this.selected].scrollIntoView({
                block: 'nearest'
            });
        },
        onArrowDown: function() {
            const { listbox } = this.$refs;
            this.selected = this.selected + 1 > this.optionsCount - 1 ? 1 : this.selected + 1;
            listbox.children[this.selected].scrollIntoView({
                block: 'nearest'
            });
        },
    }"
    x-init="init()"
>
    <input x-ref="input" {{ $attributes }} type="hidden" @input="onInput($dispatch)" />

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
        <span x-show="options[value]" x-text="options[value]" class="block truncate dark:text-theme-secondary-300"></span>
        <span x-show="!options[value]" class="block truncate dark:text-theme-secondary-700">@if(isset($placeholder) && $placeholder) {{ $placeholder }} @else &nbsp; @endif</span>

        <span
            class="{{ $iconClass }} transition duration-150 transform pointer-events-none"
            :class="{ 'rotate-180': open }"
        >
            <x-icon
                name="chevron-down"
                size="xs"
            />
        </span>
    </button>

    <div
        x-show="open"
        @click.away="open = false"
        x-description="Select popover, show/hide based on select state."
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute w-full mt-1 min-w-max-content"
        style="display: none;"
    >
        <ul
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
            <template x-for="(optionValue, index) in Object.keys(options)" :key="optionValue">
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    :id="`listbox-option-${optionValue}`"
                    role="option"
                    @click="choose(optionValue)"
                    @mouseenter="selected = index"
                    @mouseleave="selected = null"
                    :class="{
                        'bg-theme-danger-400 text-theme-secondary-200': value === optionValue || selected === index,
                    }"
                    class="px-8 py-4 font-semibold transition duration-150 ease-in-out cursor-pointer hover:bg-theme-primary-100 hover:text-theme-primary-600 dark:hover:bg-theme-primary-600 dark:hover:text-theme-secondary-200"
                    x-text="options[optionValue]"
                ></li>
            </template>
        </ul>
    </div>
</div>
