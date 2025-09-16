/**
 * hmcoders Elementor Addon - Testimonial Carousel Script
 * Version: 1.0.0
 */
(function ($) {
    'use strict';

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-testimonial-carousel.default',
            function ($scope) {
                initTestimonialCarousel($scope);
            }
        );
    });

    /**
     * Testimonial Carousel
     */
    function initTestimonialCarousel($scope) {
        $scope.find('.hmcoders-testimonial-carousel').each(function () {
            var $carousel = $(this);
            var $items = $carousel.find('.hmcoders-testimonial-item');
            if ($items.length <= 1) return;

            var settings = $carousel.data('carousel-settings') || {};
            settings.slidesToShow = parseInt(settings.slidesToShow) || 1;
            settings.slidesToScroll = parseInt(settings.slidesToScroll) || 1;
            settings.autoplay = !!settings.autoplay;
            settings.autoplaySpeed = parseInt(settings.autoplaySpeed) || 3000;
            settings.infinite = settings.infinite !== false;
            settings.dots = settings.dots !== false;
            settings.arrows = settings.arrows !== false;
            settings.pauseOnHover = settings.pauseOnHover !== false;

            var currentIndex = 0;
            var totalItems = $items.length;
            var slidesToShow = settings.slidesToShow;
            var slidesToScroll = settings.slidesToScroll;
            var autoplay = settings.autoplay;
            var autoplaySpeed = settings.autoplaySpeed;
            var infinite = settings.infinite;
            var showDots = settings.dots;
            var showArrows = settings.arrows;
            var pauseOnHover = settings.pauseOnHover;

            var autoplayInterval;
            var isTransitioning = false;

            setupCarousel();
            updateCarousel();
            if (autoplay) startAutoplay();

            function setupCarousel() {
                $items.wrapAll('<div class="hmcoders-carousel-track"></div>');
                $carousel.find('.hmcoders-carousel-track').wrap('<div class="hmcoders-carousel-viewport"></div>');

                if (showArrows) {
                    $carousel.append(
                        $('<button>', { class: 'hmcoders-carousel-arrow prev', type: 'button' }).append($('<i>', { class: 'fas fa-chevron-left' })),
                        $('<button>', { class: 'hmcoders-carousel-arrow next', type: 'button' }).append($('<i>', { class: 'fas fa-chevron-right' }))
                    );
                }

                if (showDots) {
                    var dotsHtml = $('<div>', { class: 'hmcoders-carousel-dots' });
                    var totalSlides = Math.ceil(totalItems / slidesToShow);
                    for (var i = 0; i < totalSlides; i++) {
                        dotsHtml.append($('<button>', { class: 'hmcoders-dot' + (i === 0 ? ' active' : ''), 'data-slide': i }));
                    }
                    $carousel.append(dotsHtml);
                }

                $carousel.find('.prev').on('click', function (e) { e.preventDefault(); prevSlide(); });
                $carousel.find('.next').on('click', function (e) { e.preventDefault(); nextSlide(); });
                $carousel.find('.hmcoders-dot').on('click', function (e) {
                    e.preventDefault();
                    goToSlide($(this).data('slide'));
                });

                if (pauseOnHover && autoplay) $carousel.hover(stopAutoplay, startAutoplay);
            }

            function updateCarousel() {
                if (isTransitioning) return;
                isTransitioning = true;

                var $track = $carousel.find('.hmcoders-carousel-track');
                var itemWidth = 100 / slidesToShow;
                var translateX = -(currentIndex * itemWidth);

                $items.css('width', itemWidth + '%');
                $track.css('transform', 'translateX(' + translateX + '%)');

                $carousel.find('.hmcoders-dot').removeClass('active');
                $carousel.find('.hmcoders-dot').eq(Math.floor(currentIndex / slidesToShow)).addClass('active');

                if (!infinite) {
                    $carousel.find('.prev').toggleClass('disabled', currentIndex === 0);
                    $carousel.find('.next').toggleClass('disabled', currentIndex >= totalItems - slidesToShow);
                }

                setTimeout(function () { isTransitioning = false; }, 300);
            }

            function nextSlide() {
                if (isTransitioning) return;
                currentIndex = infinite ? (currentIndex + slidesToScroll) % totalItems : Math.min(currentIndex + slidesToScroll, totalItems - slidesToShow);
                updateCarousel();
            }

            function prevSlide() {
                if (isTransitioning) return;
                currentIndex = infinite ? (currentIndex - slidesToScroll + totalItems) % totalItems : Math.max(currentIndex - slidesToScroll, 0);
                updateCarousel();
            }

            function goToSlide(slideIndex) {
                if (isTransitioning) return;
                currentIndex = slideIndex * slidesToShow;
                updateCarousel();
            }

            function startAutoplay() {
                if (!autoplay) return;
                stopAutoplay();
                autoplayInterval = setInterval(nextSlide, autoplaySpeed);
            }

            function stopAutoplay() {
                if (autoplayInterval) clearInterval(autoplayInterval);
            }
        });
    }

})(jQuery);
