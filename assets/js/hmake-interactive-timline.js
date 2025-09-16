    /**
 * hmcoders Elementor Addon - Interactive Timeline Script
 * Version: 1.0.0
 */
(function ($) {
    'use strict';

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-interactive-timeline.default',
            function ($scope) {
                initInteractiveTimeline($scope);
            }
        );
    });

    /**
     * Interactive Timeline
     */
    function initInteractiveTimeline($scope) {
        $scope.find('.hmcoders-timeline-wrapper').each(function () {
            var $timeline = $(this);
            var $items = $timeline.find('.hmcoders-timeline-item');

            // Animate items on scroll
            if ($timeline.hasClass('hmcoders-timeline-animated') && 'IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('aos-animate');
                        }
                    });
                }, { threshold: 0.3 });

                $items.each(function () { observer.observe(this); });
            } else {
                // Fallback: always visible
                $items.addClass('aos-animate visible');
            }
        });
    }

})(jQuery);
