<div class="read-more-container">
    <div
        x-data="ReadMore({ value: '{{ $content }}'})"
        :class="{ 'flex': ! showMore }"
        x-init="truncate"
        x-on:resize.window="hideAndTruncate"
        x-cloak
    >
        <div
            :class="{ truncate: ! showMore }"
            class="read-more-content"
        >
            {{ $content }}
        </div>

        <div
            class="inline-block whitespace-nowrap"
        >
            <div
                x-show="showMore"
                class="read-more-collapse link border-b border-dashed mt-2"
                @click="showMore = false && hideOptionAndTruncate()"
            >
                @lang('ui::actions.show_less')
            </div>

            <div
                x-show="! showMore && showExpand"
                class="read-more-expand link border-b border-dashed ml-2"
                @click="showAll"
            >
                @lang('ui::actions.read_more')
            </div>
        </div>
    </div>
</div>
