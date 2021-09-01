const Tags = (
    extraData = {},
    id,
    tags = [],
    allowedTags = [],
    placeholder = "Enter tags...",
    isDisabled = false,
    addDisabled = false,
    removeDisabled = false,
    disabledInputTooltip = "",
    maxTags = null,
    preserveCase = false
) => ({
    onTagRemove: null,
    onInput: null,
    onTagAdd: null,
    availableTags: tags,
    isDisabled: isDisabled,
    addDisabled: addDisabled,
    removeDisabled: removeDisabled,
    disabledInputTooltip: disabledInputTooltip,
    init() {
        const { input } = this.$refs;

        const taggle = new Taggle(input, {
            tags,
            // If we have a list of allowed tags we are preserving the case
            // since the valid options are handled by the array.
            preserveCase: preserveCase || allowedTags.length > 0,
            maxTags,
            placeholder,
            containerFocusClass: "tags-input-focus",
            tabIndex: 0,
            onTagAdd: (e, tag) => {
                if (typeof this.onTagAdd === "function") {
                    this.onTagAdd(e, tag);
                }

                this.selectTag(tag);

                this.hideTooltip();
            },
            onBeforeTagAdd: (e, tag) => {
                if (this.addDisabled) {
                    return false;
                }

                if (!allowedTags.length) {
                    // Validates:
                    // - 3 TO 30 characters
                    // - Don't start or end with a number or a special character
                    // - Only allows a-ZA-Z0-9 and - characters
                    // - No consecutives special characters
                    const allowedCharacters = /^[A-Za-z0-9 -]*$/gm;
                    const withSpecialCharsAtStart = /^[^A-Za-z]/;
                    const withSpecialCharsAtEnd = /[^A-Za-z]$/;
                    const withConsecutiveSpecialChars = /[ -]{2}/;
                    const minimumCharacters = 3;
                    const maximumCharaters = 30;

                    if (
                        tag.length < minimumCharacters ||
                        tag.length > maximumCharaters
                    ) {
                        this.displayLivewireToast(
                            "The tag must be between 3 and 30 characters."
                        );

                        return false;
                    }

                    if (withSpecialCharsAtStart.test(tag)) {
                        this.displayLivewireToast(
                            "The tag must start with a letter."
                        );

                        return false;
                    }

                    if (withSpecialCharsAtEnd.test(tag)) {
                        this.displayLivewireToast(
                            "The tag must end with a letter."
                        );

                        return false;
                    }

                    if (withConsecutiveSpecialChars.test(tag)) {
                        this.displayLivewireToast(
                            "The tag must not contain consecutive special characters."
                        );

                        return false;
                    }

                    if (!allowedCharacters.test(tag)) {
                        this.displayLivewireToast(
                            "The tag contains forbidden special characters."
                        );

                        return false;
                    }

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
            onBeforeTagRemove: () => !this.removeDisabled,
            onTagRemove: (e, tag) => {
                if (typeof this.onTagRemove === "function") {
                    this.onTagRemove(e, tag);
                }

                this.unselectTag(tag);

                this.hideTooltip();
            },
        });

        const taggleInput = taggle.getInput();
        taggleInput.setAttribute("id", id);

        if (typeof this.onInput === "function") {
            taggleInput.addEventListener("input", (e) => {
                this.onInput(e);
            });
        }

        this.$watch("isDisabled", () => {
            if (this.isDisabled) {
                taggle.disable();
            } else {
                taggle.enable();
            }

            this.initTooltip();
        });

        this.$watch("addDisabled", () => {
            this.initTooltip();
        });

        this.initTooltip();

        Livewire.on("selectedTagRemoved", (tag) => {
            taggle.remove(tag);
        });

        this.$watch("availableTags", (availableTags) => {
            const { select } = this.$refs;

            this.setTaggleTags(taggle, availableTags);

            this.$nextTick(() => {
                if (select) {
                    const options = Array.from(
                        select.querySelectorAll("option")
                    );
                    options.forEach((o) => {
                        o.selected = true;
                    });
                    select.dispatchEvent(new Event("change"));
                }
            });
        });
    },

    displayLivewireToast(validationMessage) {
        if (typeof livewire !== "undefined") {
            livewire.emit("toastMessage", [validationMessage, "warning"]);
        }
    },

    hideTooltip() {
        if (this.tooltipInstance) {
            this.tooltipInstance.destroy();
            this.tooltipInstance = null;
        }
    },
    initTooltip() {
        if (!this.disabledInputTooltip) {
            return;
        }

        this.hideTooltip();

        if (this.isDisabled || this.addDisabled || this.removeDisabled) {
            this.tooltipInstance = tippy(this.$el, {
                trigger: "mouseenter focus",
                duration: 0,
                content: this.disabledInputTooltip,
            });
        }
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
