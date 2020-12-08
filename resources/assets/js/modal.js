import {
    disableBodyScroll,
    enableBodyScroll,
    clearAllBodyScrollLocks,
} from "body-scroll-lock";

const onModalClosed = (component, modal) => {
    enableBodyScroll(modal);

    component.$nextTick(() => {
        if (!document.querySelectorAll('[data-modal]').length) {
            clearAllBodyScrollLocks();
        }
    });
}

const onModalOpened = (modal) => {
    disableBodyScroll(modal);
}

const Modal = {
    alpine(extraData = {}) {
        return {
            shown: false,
            onBeforeHide: false,
            onBeforeShow: false,
            onHidden: false,
            onShown: false,
            init() {
                const { modal } = this.$refs;

                Livewire.on('modalClosed', (m) => onModalClosed(this, m));

                Livewire.on('modalOpened', onModalOpened);

                this.$watch("shown", (shown) => {
                    if (typeof this.onBeforeShow === 'function') {
                        this.onBeforeShow();
                    }

                    if (typeof this.onBeforeHide === 'function') {
                        this.onBeforeHide();
                    }

                    this.$nextTick(() => {
                        if (shown) {
                            if (typeof this.onShown === 'function') {
                                this.onShown();
                            }

                            Livewire.emit('modalOpened', modal);

                            modal.focus();
                        } else {
                            if (typeof this.onHidden === 'function') {
                                this.onHidden();
                            }

                            enableBodyScroll(modal);

                            Livewire.emit('modalClosed', modal);
                        }
                    })
                });

                if (this.shown) {
                    Livewire.emit('modalOpened', modal);
                }

            },
            hide() {
                this.shown = false;
            },
            show() {
                this.shown = true;
            },
            ...extraData,
        };
    },
    livewire(extraData = {}) {
        return {
            init() {
                const { modal } = this.$refs;

                Livewire.on('modalClosed', () => onModalClosed(this, modal));

                Livewire.on('modalOpened', onModalOpened);

                Livewire.emit('modalOpened', modal);

                modal.focus();
            },
            ...extraData,
        };
    }
}

export default Modal;
