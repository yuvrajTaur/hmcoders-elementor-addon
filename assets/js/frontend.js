/**
 * hmcoders Elementor Addon Frontend Scripts
 * Version: 1.0.2
 */

(function($) {
    'use strict';

    // Wait for DOM ready
    $(document).ready(function() {
        initHmcodersWidgets();
    });

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function() {

        // Dynamic Post Grid
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-dynamic-post-grid.default',
            function($scope) {
                initPostGrid($scope);
            }
        );

        // Advanced Team Member
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-advanced-team-member.default',
            function($scope) {
                initTeamMember($scope);
            }
        );

        // Pricing Table
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-pricing-table.default',
            function($scope) {
                initPricingTable($scope);
            }
        );

        // Testimonial Carousel
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-testimonial-carousel.default',
            function($scope) {
                initTestimonialCarousel($scope);
            }
        );

        // Interactive Timeline
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-interactive-timeline.default',
            function($scope) {
                initInteractiveTimeline($scope);
            }
        );
    });

    /**
     * Initialize all hmcoders widgets
     */
    function initHmcodersWidgets($scope) {
        $scope = $scope || $(document);
        initPostGrid($scope);
        initTeamMember($scope);
        initPricingTable($scope);
        initTestimonialCarousel($scope);
        initInteractiveTimeline($scope);
    }

    /**
     * Post Grid
     */
    function initPostGrid($scope) {
        $scope.find('.hmcoders-post-grid').each(function() {
            var $grid = $(this);
            $grid.addClass('hmcoders-loading');

            $grid.find('.hmcoders-post-card').hover(
                function() { $(this).addClass('hovered'); },
                function() { $(this).removeClass('hovered'); }
            );

            // Lazy load
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries, obs) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.remove('lazy');
                            obs.unobserve(img);
                        }
                    });
                });

                $grid.find('img[data-src]').each(function() {
                    observer.observe(this);
                });
            }
        });
    }

    /**
     * Team Member
     */
    function initTeamMember($scope) {
        $scope.find('.hmcoders-team-member').each(function() {
            var $member = $(this);

            $member.find('.hmcoders-social-links a').on('click', function(e) {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.toLowerCase().startsWith('javascript:')) {
                    e.preventDefault();
                }
            });

            $member.hover(
                function() { $(this).addClass('hovered'); },
                function() { $(this).removeClass('hovered'); }
            );
        });
    }

    /**
     * Pricing Table
     */
    function initPricingTable($scope) {
        $scope.find('.hmcoders-pricing-table').each(function() {
            var $table = $(this);

            $table.find('.hmcoders-pricing-button').on('click', function(e) {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.toLowerCase().startsWith('javascript:')) {
                    e.preventDefault();
                }
            });

            $table.hover(
                function() { $(this).addClass('hovered'); },
                function() { $(this).removeClass('hovered'); }
            );

            if ($table.hasClass('hmcoders-featured')) {
                setTimeout(function() {
                    $table.addClass('featured-animate');
                }, 500);
            }
        });
    }

    /**
     * Testimonial Carousel
     */
    function initTestimonialCarousel($scope) {
        $scope.find('.hmcoders-testimonial-carousel').each(function() {
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

                $carousel.find('.prev').on('click', function(e) { e.preventDefault(); prevSlide(); });
                $carousel.find('.next').on('click', function(e) { e.preventDefault(); nextSlide(); });
                $carousel.find('.hmcoders-dot').on('click', function(e) {
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

                setTimeout(function() { isTransitioning = false; }, 300);
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

    /**
     * Interactive Timeline
     */
    function initInteractiveTimeline($scope) {
        $scope.find('.hmcoders-timeline-wrapper').each(function() {
            var $timeline = $(this);
            var $items = $timeline.find('.hmcoders-timeline-item');

            if ($timeline.hasClass('hmcoders-timeline-animated') && 'IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('aos-animate');
                        }
                    });
                }, { threshold: 0.3 });

                $items.each(function() { observer.observe(this); });
            } else {
                $items.addClass('aos-animate visible');
            }
        });
    }

})(jQuery);
