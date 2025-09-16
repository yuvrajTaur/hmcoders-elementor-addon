/**
 * hmcoders Elementor Addon - Advanced Team Member Script
 * Version: 1.0.0
 */
(function ($) {
    'use strict';

    // Elementor frontend init
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/hmcoders-advanced-team-member.default',
            function ($scope) {
                initTeamMember($scope);
            }
        );
    });

    /**
     * Team Member
     */
    function initTeamMember($scope) {
        $scope.find('.hmcoders-team-member').each(function () {
            var $member = $(this);

            // Prevent empty or invalid links
            $member.find('.hmcoders-social-links a').on('click', function (e) {
                var href = $(this).attr('href');
                if (!href || href === '#' || href.toLowerCase().startsWith('javascript:')) {
                    e.preventDefault();
                }
            });

            // Hover effect
            $member.hover(
                function () { $(this).addClass('hovered'); },
                function () { $(this).removeClass('hovered'); }
            );
        });
    }

})(jQuery);
