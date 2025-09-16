/**
 * hmcoders Elementor Addon - Dynamic Post Grid Script
 * Version: 1.0.0
 */
(function ($) {
    'use strict';

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-dynamic-post-grid.default',
            function ($scope) {
                initPostGrid($scope);
            }
        );
    });

    /**
     * Initialize Post Grid
     */
    function initPostGrid($scope) {
        $scope.find('.hmcoders-post-grid').each(function () {
            var $grid = $(this);
            $grid.addClass('hmcoders-loading');

            // Card hover effect
            $grid.find('.hmcoders-post-card').hover(
                function () { $(this).addClass('hovered'); },
                function () { $(this).removeClass('hovered'); }
            );

            // Lazy load images
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries, obs) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            var img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.remove('lazy');
                            obs.unobserve(img);
                        }
                    });
                });

                $grid.find('img[data-src]').each(function () {
                    observer.observe(this);
                });
            }
        });
    }

})(jQuery);
