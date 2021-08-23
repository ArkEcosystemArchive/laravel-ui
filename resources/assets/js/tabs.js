const Tabs = (defaultSelected = "", extraData = {}, onSelected = () => {}) => {
    return {
        selected: defaultSelected,
        select(name) {
            this.selected = name;
            this.$refs[name].focus();

            this.onSelected(name);
        },
        keyboard(e) {
            const tabs = e.target.closest("[role=tablist]").querySelectorAll("[role=tab]");
            let index = Array.prototype.indexOf.call(tabs, e.currentTarget);
            // On some screen readers the down arrow moves user to the next element.
            // We intercept the down arrow key and move focus on the open panel.
            let dir = e.keyCode === 37 ? index - 1 : e.keyCode === 39 ? index + 1 : e.keyCode === 40 ? 'down' : null;

            if (dir !== null) {
                if (dir === 'down') {
                    this.select(e.currentTarget.id.replace("tab-", ""));
                } else if (tabs[dir]) {
                    this.select(tabs[dir].id.replace("tab-", ""));
                }
            }
        },
        onSelected: onSelected,
        ...extraData,
    };
};

window.Tabs = Tabs;
