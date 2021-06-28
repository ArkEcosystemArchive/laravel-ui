import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";

const Modal = {
    previousPaddingRight: undefined,

    onModalOpened(scrollable, options = {}) {
        if (options.reserveScrollBarGap) {
            this.reserveModalScrollBarGap(scrollable);
        }

        disableBodyScroll(scrollable, {
            reserveScrollBarGap: !! options.reserveScrollBarGap,
        });

        scrollable.focus();
    },

    onModalClosed(scrollable, options = {}) {
        if (options.reserveScrollBarGap) {
            this.restoreModalScrollBarGap(scrollable);
        }

        enableBodyScroll(scrollable);

        if (!document.querySelectorAll("[data-modal]").length) {
            clearAllBodyScrollLocks();
        }
    },

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

                    Livewire.on("closeModal", (modalName) => {
                        if (this.name === modalName) {
                            this.hide();
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

                            Modal.onModalOpened(scrollable);
                        } else {
                            if (typeof this.onHidden === "function") {
                                this.onHidden();
                            }

                            Modal.onModalClosed(scrollable);
                        }
                    });
                });

                if (this.shown) {
                    Modal.onModalOpened(scrollable);
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

    livewire(extraData = {}, eventOptions = {}) {
        return {
            init() {
                const scrollable = this.getScrollable();

                this.$wire.on("modalClosed", () => {
                    this.$nextTick(() => {
                        Modal.onModalClosed(scrollable, eventOptions);
                    });
                });

                Modal.onModalOpened(scrollable, eventOptions);
            },
            getScrollable() {
                const { modal } = this.$refs;
                return modal;
            },
            ...extraData,
        };
    },

    // Variation of https://github.com/willmcpo/body-scroll-lock/blob/master/src/bodyScrollLock.js#L72
    reserveModalScrollBarGap(container) {
        if (this.previousPaddingRight === undefined) {
            const scrollBarGap = window.innerWidth - document.documentElement.clientWidth;
            console.log(scrollBarGap);

            if (scrollBarGap > 0) {
                const computedBodyPaddingRight = parseInt(window.getComputedStyle(container).getPropertyValue('padding-right'), 10);
                this.previousPaddingRight = container.style.paddingRight;
                container.style.paddingRight = `${computedBodyPaddingRight + scrollBarGap}px`;
            }
        }
    },

    // Variation of https://github.com/willmcpo/body-scroll-lock/blob/master/src/bodyScrollLock.js#L92
    restoreModalScrollBarGap(container) {
        if (this.previousPaddingRight !== undefined) {
            container.style.paddingRight = this.previousPaddingRight;

            this.previousPaddingRight = undefined;
        }
    },
};

export default Modal;
