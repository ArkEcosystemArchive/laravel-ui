const ReadOnly = ({ value }) => ({
    value,
    showMore: false,
    showExpand: false,
    truncate() {
        const el = this.$el.querySelector('.read-more-content');
        const expand = this.$el.querySelector('.read-more-expand');

        expand.style.display = 'none';
        el.innerHTML = '';
        el.appendChild(document.createTextNode(this.value));

        if (! this.hasOverflow(el)) {
            return;
        }

        let length = this.value.length;
        do {
            const a = this.value.substr(0, length);
            const truncated = a + '...';

            el.innerHTML = ''
            el.appendChild(document.createTextNode(truncated));

            length--;

            this.showExpand = true;
        } while(length > 1 && this.hasOverflow(el));
    },
    showAll() {
        const el = this.$el.querySelector('.read-more-content');

        el.innerHTML = '';
        el.appendChild(document.createTextNode(this.value));
        this.showMore = true;
    },
    hideOptionAndTruncate() {
        this.showExpand = false;

        this.truncate();
    },
    hasOverflow(el) {
        console.log({ el, offsetWidth: el.offsetWidth, scrollWidth: el.scrollWidth, })
        return el.offsetWidth < el.scrollWidth;
    },
});

export default ReadOnly;
