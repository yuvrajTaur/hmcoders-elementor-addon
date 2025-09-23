/**
 * hmcoders Elementor Addon - Enhanced Interactive Timeline Script
 * Version: 2.1.0 - Horizontal Timeline with Scroll Navigation
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

    function initInteractiveTimeline($scope) {
        $scope.find('.hmcoders-timeline-wrapper').each(function () {
            const $timeline = $(this);
            const $items = $timeline.find('.hmcoders-timeline-item');
            const isHorizontal = $timeline.hasClass('hmcoders-timeline-horizontal');

            if (isHorizontal) {
                initHorizontalTimeline($timeline);
            } else {
                initVerticalTimeline($timeline);
            }

            if ($timeline.hasClass('hmcoders-timeline-animated')) {
                initScrollAnimations($timeline, $items);
            }
        });
    }

    function initHorizontalTimeline($timeline) {
        const $container = $timeline.find('.hmcoders-timeline-items-container');
        if (!$container.length) return;

        // Mouse wheel horizontal scrolling
        $timeline.on('wheel', function (e) {
            if (window.innerWidth > 768) {
                e.preventDefault();
                const delta = e.originalEvent.deltaY;
                const scrollAmount = Math.abs(delta) > 100 ? delta : delta * 3;
                $container.scrollLeft($container.scrollLeft() + scrollAmount);
            }
        });

        // Touch/swipe support for mobile
        initTouchEvents($container);
    }

    function initVerticalTimeline($timeline) {
        const $items = $timeline.find('.hmcoders-timeline-item');
        $items.each(function (index) {
            $(this).css('animation-delay', (index * 0.2) + 's');
        });
    }

    function initTouchEvents($container) {
        let startX = 0;
        let scrollLeft = 0;

        $container.on('touchstart', function (e) {
            startX = e.originalEvent.touches[0].pageX;
            scrollLeft = $container.scrollLeft();
        });

        $container.on('touchmove', function (e) {
            const x = e.originalEvent.touches[0].pageX;
            const walk = (startX - x);
            $container.scrollLeft(scrollLeft + walk);
        });
    }

    function initScrollAnimations($timeline, $items) {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('aos-animate');
                    }
                });
            }, { threshold: 0.2 });

            $items.each(function () {
                observer.observe(this);
            });
        } else {
            $items.addClass('aos-animate');
        }
    }
})(jQuery);
