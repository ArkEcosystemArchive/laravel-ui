const Dropdown = {
    defaultSettings: {
        onOpened: null,
        onClosed: null,
        repositionOnOpen: true,
    },

    onOpened(settings = Dropdown.defaultSettings) {
        this.$el.querySelectorAll('img[onload]').forEach(img => {
            if (img.onload) {
                img.onload();
                img.removeAttribute('onload');
            }
        });

        if (settings.repositionOnOpen) {
            Dropdown.repositionOutOfBounds.call(this, this.$el);
        }
    },

    onClosed(settings = Dropdown.defaultSettings) {
        if (settings.onClosed) {
            settings.onClosed(this.$el);
        }
    },

    repositionOutOfBounds(container) {
        console.log('repositionOutOfBounds');
        const dropdown = container.querySelector('.dropdown');
        // dropdown.style.marginTop = null;
        // container.style.position = null;
        dropdown.style.bottom = null;
        dropdown.style.top = null;

        this.$nextTick(() => {
            const bounds   = dropdown.getBoundingClientRect();

            const dropdownBottom =
                bounds.top +
                document.documentElement.scrollTop +
                parseInt(dropdown.getBoundingClientRect().height); // -
                // (parseInt(dropdown.style.marginTop) || 0);

            console.log(dropdownBottom, parseInt(dropdown.getBoundingClientRect().height));

            if (dropdownBottom > document.body.clientHeight) {
                // dropdown.style.marginTop = `-${dropdownBottom - document.body.clientHeight + 40}px`;
                // console.log(dropdown.style.marginTop);

                container.style.position = 'static';
                dropdown.style.bottom = '0';
                dropdown.style.top = 'auto';
            }
        });
    },

    setup(propertyName = 'dropdownOpen', settings = Dropdown.defaultSettings) {
        settings = {...Dropdown.defaultSettings, ...settings};
        const alpineSetup = {
            propertyName,

            init() {
                this.$watch(propertyName, (expanded) => {
                    console.log('setup watch open', expanded);

                    if (expanded) {
                        this.$nextTick(() => Dropdown.onOpened.call(this, settings));
                    } else {
                        this.$nextTick(() => Dropdown.onClosed.call(this, settings));
                    }
                });
            },

            repositionOnClick() {
                // this.$nextTick(() => console.log('wut', this.$el));
                // Dropdown.repositionOutOfBounds.call(this, this.$el);
            },

            toggle() {
                this[this.propertyName] = ! this[this.propertyName];
            },
        };

        alpineSetup[propertyName] = false;

        return alpineSetup;
    },
};

export default Dropdown;
