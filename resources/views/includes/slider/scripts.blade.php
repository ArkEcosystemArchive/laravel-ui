<script>
    function getKeyboardFocusableElements (el) {
        var elements = el.querySelectorAll('a, button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])');

        return Array.from(elements).filter(el => !el.hasAttribute('disabled'));
    }

    function elementIsVisibleIn (wrapper, el) {
        var wrapperRect = wrapper.getBoundingClientRect();
        var elRect = el.getBoundingClientRect();

        return elRect.top >= wrapperRect.top && elRect.bottom <= wrapperRect.bottom && elRect.left >= wrapperRect.left && elRect.right <= wrapperRect.right
    }

    function disableTabIndexOfInvisibleElements (sliderWrapper, slides) {
        slides.forEach(slide => {
            if (elementIsVisibleIn(sliderWrapper, slide)) {
                const elements = slide.querySelectorAll('[data-custom-tabindex]')
                elements.forEach(function(el) {
                    el.removeAttribute('tabindex');
                    el.removeAttribute('data-custom-tabindex');
                })
            } else {
                const focusableElements = getKeyboardFocusableElements(slide);
                focusableElements.forEach(function(el) {
                    el.setAttribute('tabindex', '-1');
                    el.setAttribute('data-custom-tabindex', 'true');
                })
            }
        });
    }

    new Swiper('#swiper-{{ $id }}', {
        @if($keyboardScroll)
        keyboard: {
            enabled: true,
            onlyInViewport: true,
        },
        @endif
        slidesPerView: 1,
        slidesPerGroup: 1,
        slidesPerColumn: 1,
        spaceBetween: {{ $spaceBetween }},
        @if($breakpoints)
            breakpoints: {!! $breakpoints !!},
        @else
            breakpoints: {
                @if ($columns > 1)
                375: {
                    slidesPerGroup: {{ $columns - 3 > 0 ? $columns - 3 : 2 }},
                    slidesPerView: {{ $columns - 3 > 0 ? $columns - 3 : 2 }},
                },
                640: {
                    slidesPerGroup: {{ $columns - 2 > 0 ? $columns - 2 : 3 }},
                    slidesPerView: {{ $columns - 2 > 0 ? $columns - 2 : 3 }}
                },
                1024: {
                    slidesPerGroup: {{ $columns - 1 > 0 ? $columns - 1 : 4 }},
                    slidesPerView: {{ $columns - 1 > 0 ? $columns - 1 : 4 }}
                },
                1280: {
                @else
                1024: {
                @endif
                    slidesPerGroup: {{ $columns }},
                    slidesPerView: {{ $columns }},
                    @if ($rows > 1)
                        slidesPerColumn: {{ $rows }},
                        slidesPerColumnFill: 'row',
                    @endif
                },
            },
        @endif
        loop: {{ $loop ? 'true' : 'false' }},
        loopFillGroupWithBlank: true,
        @if ($autoplay)
        autoplay: {
            delay: {{ $autoplayDelay }},
        },
        @endif
        @unless ($hideBullets)
        pagination: {
            el: '#swiper-{{ $id }} .swiper-pagination',
            clickable: true
        },
        @endif
        @unless ($hideNavigation)
        navigation: {
            nextEl: '.swiper-{{ $id }}-pagination.swiper-button-next',
            prevEl: '.swiper-{{ $id }}-pagination.swiper-button-prev'
        },
        @endunless
        watchOverflow: true,
        allowTouchMove: {{ $allowTouch ? 'true' : 'false' }},
        on: {
            init: function () {
                disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            },
            slideChangeTransitionEnd: function () {
                disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            },
            snapGridLengthChange: function () {
                disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            },
        }
    });
</script>
