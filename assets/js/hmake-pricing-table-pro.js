/**
 * hmcoders Elementor Addon - Pricing Table Script
 * Version: 1.0.0
 */
(function ($) {
    'use strict';

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-pricing-table.default',
            function ($scope) {
                initPricingTable($scope);
            }
        );
    });

    /**
     * Pricing Table
     */
    function initPricingTable($scope) {
        $scope.find('.hmcoders-pricing-table').each(function () {
            var $table = $(this);

            // Prevent invalid button links
            $table.find('.hmcoders-pricing-button').on('click', function (e) {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.toLowerCase().startsWith('javascript:')) {
                    e.preventDefault();
                }
            });

            // Hover animation
            $table.hover(
                function () { $(this).addClass('hovered'); },
                function () { $(this).removeClass('hovered'); }
            );

            // Featured highlight animation
            if ($table.hasClass('hmcoders-featured')) {
                setTimeout(function () {
                    $table.addClass('featured-animate');
                }, 500);
            }
        });
    }

})(jQuery);
