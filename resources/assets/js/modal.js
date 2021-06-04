import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";

const onModalClosed = (scrollable) => {
    enableBodyScroll(scrollable);

    if (!document.querySelectorAll("[data-modal]").length) {
        clearAllBodyScrollLocks();
    }
};

const onModalOpened = (scrollable) => {
    disableBodyScroll(scrollable);

    scrollable.focus();
};

const Modal = {
    alpine(extraData = {}, modalName = "") {
        return {
            name: modalName,
            shown: false,
            onBeforeHide: false,
            onBeforeShow: false,
            onHidden: false,
            onShown: false,
            init() {
                const scrollable = this.getScrollable();
                if (this.name) {
                    Livewire.on("openModal", (modalName) => {
                        if (this.name === modalName) {
                            this.show();
                        }
                    });
                }

                this.$watch("shown", (shown) => {
                    if (typeof this.onBeforeShow === "function") {
                        this.onBeforeShow();
                    }

                    if (typeof this.onBeforeHide === "function") {
                        this.onBeforeHide();
                    }

                    this.$nextTick(() => {
                        if (shown) {
                            if (typeof this.onShown === "function") {
                                this.onShown();
                            }

                            onModalOpened(scrollable);
                        } else {
                            if (typeof this.onHidden === "function") {
                                this.onHidden();
                            }

                            onModalClosed(scrollable);
                        }
                    });
                });

                if (this.shown) {
                    onModalOpened(scrollable);
                }
            },
            hide() {
                this.shown = false;
            },
            show() {
                this.shown = true;
            },
            getScrollable() {
                const { modal } = this.$refs;
                return modal;
            },
            ...extraData,
        };
    },
    livewire(extraData = {}) {
        return {
            init() {
                const scrollable = this.getScrollable();

                this.$wire.on("modalClosed", () => {
                    this.$nextTick(() => {
                        onModalClosed(scrollable);
                    });
                });

                onModalOpened(scrollable);
            },
            getScrollable() {
                const { modal } = this.$refs;
                return modal;
            },
            ...extraData,
        };
    },
};

export default Modal;
