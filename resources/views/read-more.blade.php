<div class="read-more-container">
    <div
        x-data="ReadMore({ value: '{{ $content }}'})"
        :class="{ 'flex': ! showMore }"
        x-init="truncate"
        x-on:resize.window="hideOptionAndTruncate"
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
                class="mt-2 border-b border-dashed read-more-collapse link link-no-underline"
                @click="showMore = false && hideOptionAndTruncate()"
            >
                @lang('ui::actions.show_less')
            </div>

            <div
                x-show="! showMore && showExpand"
                class="ml-2 border-b border-dashed read-more-expand link link-no-underline"
                @click="showAll"
            >
                @lang('ui::actions.read_more')
            </div>
        </div>
    </div>
</div>
