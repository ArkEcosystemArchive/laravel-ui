const Slider = {
    getKeyboardFocusableElements (el) {
        var elements = el.querySelectorAll('a, button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])');

        return Array.from(elements).filter(el => !el.hasAttribute('disabled'));
    },

    elementIsVisibleIn (wrapper, el) {
        var wrapperRect = wrapper.getBoundingClientRect();
        var elRect = el.getBoundingClientRect();

        return elRect.top >= wrapperRect.top && elRect.bottom <= wrapperRect.bottom && elRect.left >= wrapperRect.left && elRect.right <= wrapperRect.right
    },

    disableTabIndexOfInvisibleElements (sliderWrapper, slides) {
        slides.forEach(slide => {
            if (this.elementIsVisibleIn(sliderWrapper, slide)) {
                const elements = slide.querySelectorAll('[data-custom-tabindex]')
                elements.forEach(function(el) {
                    el.removeAttribute('tabindex');
                    el.removeAttribute('data-custom-tabindex');
                })
            } else {
                const focusableElements = this.getKeyboardFocusableElements(slide);
                focusableElements.forEach(function(el) {
                    el.setAttribute('tabindex', '-1');
                    el.setAttribute('data-custom-tabindex', 'true');
                })
            }
        });
    },

    setupKeyboardEvents (swiper) {
        swiper.$el[0].addEventListener('keydown', function(e) {
            if (e.code === 'ArrowRight') {
                swiper.slideNext();
            } else if (e.code === 'ArrowLeft') {
                swiper.slidePrev();
            }
        });
    },
};

export default Slider;
