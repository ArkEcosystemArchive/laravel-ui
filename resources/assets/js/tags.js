const Tags = (extraData = {}, tags = [], allowedTags = [], maxTags = null) => ({
    onTagRemove: null,
    onInput: null,
    onTagAdd: null,
    availableTags: tags,
    init() {
        const { input } = this.$refs;

        const taggle = new Taggle(input, {
            tags: tags,
            preserveCase: true,
            maxTags: maxTags,
            containerFocusClass: "tags-input-focus",
            onTagAdd: (e, tag) => {
                if (typeof this.onTagAdd === "function") {
                    this.onTagAdd(e, tag);
                }

                this.selectTag(tag);
            },
            onBeforeTagAdd(e, tag) {
                if (!allowedTags.length) {
                    return true;
                }

                // Workaround to use the tag in the correct case even if the user
                // type it wrong
                const allowedTag = allowedTags.find((t) => {
                    return t.toUpperCase().trim() == tag.toUpperCase().trim();
                });

                if (allowedTag && allowedTag !== tag) {
                    taggle.add(allowedTag);
                    return false;
                }

                return !!allowedTag;
            },
            onTagRemove: (e, tag) => {
                if (typeof this.onTagRemove === "function") {
                    this.onTagRemove(e, tag);
                }

                this.unselectTag(tag);
            },
        });

        const taggleInput = taggle.getInput();

        if (typeof this.onInput === "function") {
            taggleInput.addEventListener("input", (e) => {
                this.onInput(e);
            });
        }

        this.$watch("availableTags", (availableTags) => {
            const { select } = this.$refs;

            this.setTaggleTags(taggle, availableTags);
            this.$nextTick(() => {
                const options = Array.from(select.querySelectorAll("option"));
                options.forEach((o) => {
                    o.selected = true;
                });
                select.dispatchEvent(new Event("change"));
            });
        });
    },
    selectTag(tag) {
        const availableTag = this.availableTags.find((t) => t === tag);
        if (!availableTag) {
            this.availableTags.push(tag);
        }
    },
    unselectTag(tag) {
        const tagIndex = this.availableTags.findIndex((t) => t === tag);
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
