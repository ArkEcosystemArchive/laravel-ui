window.UserTagger = (
    endpoint,
    contextUsers,
    maxLength = null,
    plainText = false
) => {
    const options = {
        selectClass: "highlighted",
        containerClass:
            "ark-user-tagger bg-white rounded-md shadow-lg py-6 z-50 left-0 sm:left-auto w-full sm:w-auto",

        noMatchTemplate: () => '<span class="hidden"></span>',

        selectTemplate(item) {
            return `<a
                data-username="${item.original.username}"
                contenteditable="false"
                class="link font-semibold"
            >@${item.original.username}</a>`;
        },

        menuItemTemplate(item) {
            const hasAvatar = !item.original.avatar.startsWith("<svg");

            const avatar = hasAvatar
                ? `<img class="absolute object-cover w-full h-full" src="${item.original.avatar}" alt="${item.original.username}"/>`
                : item.original.avatar;

            return `<div class="flex p-3 space-x-3 items-center cursor-pointer">
                <div class="w-6">
                    <div class="relative w-full overflow-hidden rounded border border-theme-secondary-300 ${
                        hasAvatar ? "pb-full h-0" : ""
                    }">
                        ${avatar}
                    </div>
                </div>
                <span class="ark-user-tagger--username font-semibold text-theme-secondary-800">${
                    item.original.username
                }</span>
                <span class="text-sm text-theme-secondary-500">${
                    item.original.name
                }</span>
            </div>`;
        },

        latestFetchController: null,
        fetchThrottlingTimeout: null,

        values(text, cb) {
            if (this.fetchThrottlingTimeout) {
                clearTimeout(this.fetchThrottlingTimeout);
            }

            // Workaround to reduce the amount of request while user is typing
            this.fetchThrottlingTimeout = setTimeout(() => {
                if (this.latestFetchController) {
                    this.latestFetchController.abort();
                }

                this.latestFetchController = new AbortController();
                const { signal } = this.latestFetchController;

                let query = `?q=${text}`;
                if (Array.isArray(contextUsers) && contextUsers.length) {
                    query = `${query}&context=${contextUsers.join(",")}`;
                }

                fetch(`${endpoint}${query}`, { signal })
                    .then((response) => response.json())
                    .then((data) => cb(data))
                    .catch((error) => {
                        if (error.name !== "AbortError") {
                            throw error;
                        }
                    });

                this.fetchThrottlingTimeout = null;
            }, 100);
        },

        lookup: (item) => item.name + item.username,
    };

    if (plainText) {
        options.selectTemplate = (item) => `@${item.original.username}`;
    }

    const tribute = new Tribute(options);

    return {
        latestValue: "",

        moveCursorToTheEndOfTheEditor(editor) {
            const range = document.createRange();
            range.selectNodeContents(editor);
            range.collapse(false);
            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
        },

        updateValue(e) {
            const { input, editor } = this.$refs;

            const value = this.getRawValue(e);

            if (maxLength !== null) {
                if (value.length > maxLength) {
                    editor.innerHTML = this.latestValue;
                    this.moveCursorToTheEndOfTheEditor(editor);

                    return;
                }

                // Since the content of the `contenteditable` field contains HTML,
                // I cant remove the last character (used to emulate the max length behavior)
                // because I can potentially break the HTML content.
                // As a workaround, I'm using this variable to store the latest valid content.
                // If the user passes the maxLength, I can rollback to this value and prevent
                // texts longer than the maxLength.
                this.latestValue = e.target.innerHTML;
            }

            input.value = value;

            input.dispatchEvent(
                new Event("input", {
                    bubbles: true,
                    cancelable: true,
                })
            );
        },

        getRawValue(e) {
            if (plainText) {
                return e.target.value;
            }

            return String(e.target.innerHTML)
                .replace(/<div><br>/gi, "\n")
                .replace(/<div>/gi, "\n")
                .replace(/<\/div>/gi, "")
                .replaceAll(/<br>/gi, "\n");
        },

        init() {
            const { input, editor } = this.$refs;

            editor.innerHTML = input.value;
            this.latestValue = input.value;

            tribute.attach(editor);

            editor.addEventListener("input", (e) => {
                this.updateValue(e);
            });

            editor.addEventListener("blur", (e) => this.updateValue(e));
        },
    };
};
