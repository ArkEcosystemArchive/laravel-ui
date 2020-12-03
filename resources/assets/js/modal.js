import { disableBodyScroll, enableBodyScroll, clearAllBodyScrollLocks } from "body-scroll-lock";

const Modal = (extraData = {}) => {
    return {
        shown: true,
        init() {
            this.$watch('shown', (shown) => {
                if (shown) {
                    this.disableBodyScroll()
                } else {
                    this.enableBodyScroll()
                }
            })

            if (this.shown) {
                this.disableBodyScroll()

                // If the modal is shown when created, it was added with livewire, this kind of modals are just removed
                // from the DOM  when closed, so there is no easy universal way to know if the modal was closed.
                // The following interval detects when the modal is closed by continually checks for the modal existence.
                const interval = setInterval(() => {
                    const openedModals = document.querySelectorAll('[data-modal]').length
                    if (openedModals === 0) {
                        this.shown = false
                        clearInterval(interval);
                    }
                }, 500);
            } else {
                this.enableBodyScroll()
            }
        },
        disableBodyScroll() {
            const { modal } = this.$refs;

            disableBodyScroll(modal);
        },
        enableBodyScroll() {
            const { modal } = this.$refs;

            if (modal) {
                enableBodyScroll(modal);
            } else {
                clearAllBodyScrollLocks()
            }
        },
        ...extraData,
    };
};

export default Modal;
