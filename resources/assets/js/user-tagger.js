window.UserTagger = (contextUsers, maxLength = null) => {
    const tribute = new Tribute({
        selectClass: "highlighted",
        containerClass:
            "UserTagger bg-white rounded-md shadow-lg py-6 z-50 left-0 sm:left-auto w-full sm:w-auto",
        noMatchTemplate: () => '<span class="hidden"></span>',
        selectTemplate(item) {
            return `<a data-username="${item.original.username}" href="#" contenteditable="false" class="bg-theme-primary-100 text-theme-primary-600 font-semibold">@${item.original.username}</a>`;
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
                <span class="UserTagger--username font-semibold text-theme-secondary-800">${
                    item.original.username
                }</span>
                <span class="text-sm text-theme-secondary-500">${
                    item.original.name
                }</span>
            </div>`;
        },
        latestFethController: null,
        fetchThrottlingTimeout: null,
        values(text, cb) {
            if (this.fetchThrottlingTimeout) {
                clearTimeout(this.fetchThrottlingTimeout);
            }

            // Workaround to reduce the amount of request while user is typing
            this.fetchThrottlingTimeout = setTimeout(() => {
                if (this.latestFethController) {
                    this.latestFethController.abort();
                }

                this.latestFethController = new AbortController();
                const { signal } = this.latestFethController;

                let query = `?q=${text}`;
                if (Array.isArray(contextUsers) && contextUsers.length) {
                    query = `${query}&context=${contextUsers.join(",")}`;
                }

                fetch(`/api/users/autocomplete${query}`, { signal })
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
        lookup: (item) => item.name,
    });

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

            console.log(e.target.innerHTML, value);

            if (maxLength !== null) {
                if (value.length > maxLength) {
                    editor.innerHTML = this.latestValue;
                    this.moveCursorToTheEndOfTheEditor(editor);

                    return;
                }

                // Store the latest value in case we need to rollback the
                // input value the users reaches the maxLength
                this.latestValue = e.target.innerHTML;
            }

            input.value = value;
            var event = new Event("input", {
                bubbles: true,
                cancelable: true,
            });
            input.dispatchEvent(event);
        },
        getRawValue(e) {
            return String(e.target.innerHTML)
                .replace(/<div><br>/gi, "\n")
                .replace(/<div>/gi, "\n")
                .replace(/<\/div>/gi, "")
                .replaceAll(/<br>/gi, "\n");
        },
        init() {
            const { editor } = this.$refs;

            tribute.attach(editor);

            editor.addEventListener("input", (e) => {
                console.log(e);
                this.updateValue(e);
            });

            editor.addEventListener("blur", (e) => this.updateValue(e));
        },
    };
};
