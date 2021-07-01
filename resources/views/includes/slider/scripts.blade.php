<script>
    (() => {
        const swiper = new Swiper('#swiper-{{ $id }}', {
            slidesPerView: 1,
            slidesPerGroup: 1,
            slidesPerColumn: 1,
            spaceBetween: {{ $spaceBetween }},
            breakpoints: {!! json_encode($breakpoints) !!},
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
                beforeInit: function () {
                    const wrapper = this.$el[0].querySelector('.swiper-wrapper');
                    wrapper.classList.remove('grid');
                    wrapper.removeAttribute('style');
                },
            },
        });

        document.addEventListener('DOMContentLoaded', function() {
            swiper.on('init', function () {
                Slider.disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            });

            swiper.on('slideChangeTransitionEnd', function () {
                Slider.disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            });

            swiper.on('snapGridLengthChange', function () {
                Slider.disableTabIndexOfInvisibleElements(this.$el[0], this.slides);
            });

            Slider.setupKeyboardEvents(swiper);
        });
    })();
</script>
