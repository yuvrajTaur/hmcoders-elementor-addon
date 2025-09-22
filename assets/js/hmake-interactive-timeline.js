/**
 * hmcoders Elementor Addon - Interactive Timeline Script
 * Version: 1.5.0 - Horizontal Line Width Fixed
 */
(function ($) {
    'use strict';

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-interactive-timeline.default',
            function ($scope) {
                initInteractiveTimeline($scope);
            }
        );
    });

    /**
     * Init Interactive Timeline
     */
    function initInteractiveTimeline($scope) {
        $scope.find('.hmcoders-timeline-wrapper').each(function () {
            const $timeline = $(this);
            const $items = $timeline.find('.hmcoders-timeline-item');
            const isHorizontal = $timeline.hasClass('hmcoders-timeline-horizontal');

            // Horizontal-specific behaviors
            if (isHorizontal) {
                initHorizontalScroll($timeline);
                updateTimelineLineWidth($timeline);
                $(window).on('resize', function () {
                    updateTimelineLineWidth($timeline);
                });
            }

            // Scroll animation (AOS)
            if ($timeline.hasClass('hmcoders-timeline-animated') && 'IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('aos-animate');   
                        }
                    });
                }, { threshold: 0.3 });

                $items.each(function () {
                    observer.observe(this);
                });
            } else {
                // Fallback
                $items.addClass('aos-animate visible');
            }
        });
    }

    /**
     * Initialize horizontal scroll and mousewheel
     */
    function initHorizontalScroll($timeline) {
        const $container = $timeline.find('.hmcoders-timeline-items-container');

        // Smooth horizontal scroll with mouse wheel
        $timeline.on('wheel', function (e) {
            if (window.innerWidth > 768) {
                e.preventDefault();
                const delta = e.originalEvent.deltaY;
                $container.scrollLeft($container.scrollLeft() + delta);
            }
        });

        // Optional: Auto scroll (uncomment to use)
        /*
        const $items = $timeline.find('.hmcoders-timeline-item');
        let currentIndex = 0;
        setInterval(function () {
            if (currentIndex < $items.length - 1) {
                currentIndex++;
                const itemOffset = $items.eq(currentIndex).position().left;
                $container.animate({
                    scrollLeft: itemOffset
                }, 800);
            }
        }, 5000);
        */
    }

    /**
     * Fix the timeline line width to match content width
     */
    function updateTimelineLineWidth($timeline) {
        const $line = $timeline.find('.hmcoders-timeline-line');
        const $container = $timeline.find('.hmcoders-timeline-items-container');

        if ($line.length && $container.length) {
            // Match the scrollWidth of the container
            const fullWidth = $container[0].scrollWidth;
            $line.css('width', fullWidth + 'px');
        }
    }

})(jQuery);
