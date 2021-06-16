import { disableBodyScroll, enableBodyScroll } from "body-scroll-lock";

const onNavbarClosed = (navbar) => {
    enableBodyScroll(navbar);
};

const onNavbarOpened = (navbar) => {
    disableBodyScroll(navbar);

    navbar.focus();
};

const Navbar = {
    dropdown(xData = {}) {
        return {
            open: false,
            openDropdown: null,
            selectedChild: null,
            scrollProgress: 0,
            nav: null,
            dark: false,
            lockBodyBreakpoint: 640,
            onScroll() {
                const progress = this.getScrollProgress();
                if (progress !== this.scrollProgress) {
                    this.scrollProgress = progress;
                    this.updateShadow(progress);
                }
            },
            getScrollProgress() {
                const navbarHeight = 82;
                return Math.min(
                    1,
                    document.documentElement.scrollTop / navbarHeight
                );
            },
            updateShadow(progress) {
                const maxTransparency = this.dark ? 0.6 : 0.22 ;
                const shadowTransparency =
                    Math.round(maxTransparency * progress * 100) / 100;
                const borderTransparency =
                    Math.round((1 - progress) * 100) / 100;
                const borderColorRgb = this.dark ? [60, 66, 73] : [219, 222, 229];
                const boxShadowRgb = this.dark ? [18, 18, 19] :  [192, 200, 207];
                this.nav.style.boxShadow = `0px 2px 10px 0px rgba(${boxShadowRgb.join(', ')}, ${shadowTransparency})`;
                this.nav.style.borderColor = `rgba(${borderColorRgb.join(', ')}, ${borderTransparency})`;
            },
            init() {
                const { nav, scrollable } = this.$refs;
                this.nav = nav;
                window.onscroll = this.onScroll.bind(this);
                this.scrollProgress = this.getScrollProgress();
                this.updateShadow(this.scrollProgress);

                this.$watch("dark", () => this.updateShadow(this.getScrollProgress()));

                this.$watch("open", (open) => {
                    this.$nextTick(() => {
                        if (open) {
                            if (this.lockBody()) {
                                onNavbarOpened(scrollable || nav);
                            }
                        } else {
                            onNavbarClosed(scrollable || nav);
                        }
                    });
                });

                if (this.open && this.lockBody()) {
                    onNavbarOpened(scrollable || nav);
                }
            },
            hide() {
                this.open = false;
            },
            show() {
                this.open = true;
            },
            lockBody() {
                return window.innerWidth <= this.lockBodyBreakpoint;
            },
            ...xData,
        };
    },
};

export default Navbar;
