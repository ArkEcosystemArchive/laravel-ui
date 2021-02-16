const Tags = (
    extraData = {},
    tags = [],
    maxTags = null
) => ({
    onTagRemove: null,
    onTagAdd: null,
    availableTags: tags,
    init() {
        const { input } = this.$refs;

        const taggle = new Taggle(input, {
            tags: tags,
            preserveCase: true,
            maxTags: maxTags,
            containerFocusClass: 'tagsFocus',
            onTagAdd: (e, tag) => {
                if (typeof this.onTagAdd === 'function') {
                    this.onTagAdd(e, tag);
                }

                this.selectTag(tag);
            },

            onTagRemove: (e, tag) => {
                if (typeof this.onTagRemove === 'function') {
                    this.onTagRemove(e, tag);
                }

                this.unselectTag(tag);
            },
        });


        this.$watch('availableTags', (availableTags) => {
            const { select } = this.$refs;

            this.setTaggleTags(taggle, availableTags);
            this.$nextTick(() => {
                const options = Array.from(select.querySelectorAll('option'));
                options.forEach(o => {
                    o.selected = true;
                })
                select.dispatchEvent(new Event('change'));
            })
        })
    },
    selectTag(tag) {
        const availableTag = this.availableTags.find(t => t === tag);
        if (!availableTag) {
            this.availableTags.push(tag);
        }
    },
    unselectTag(tag) {
        const tagIndex = this.availableTags.findIndex(t => t === tag);
        this.availableTags.splice(tagIndex, 1);
    },
    setTaggleTags(taggle, tags) {
        for (const tag of Object.values(taggle.getTags())) {
            taggle.remove(tag, true);
        }

        for (const tag of Object.values(tags)) {
            taggle.add(tag);
        }
    },

    ...extraData,
});

export default Tags;
