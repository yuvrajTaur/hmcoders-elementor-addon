/**
 * hmcoders Elementor Addon - Testimonial Carousel Script (Fixed, No Duplicate Arrows)
 * Version: 1.2.0
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
   * Initialize Testimonial Carousel
   */
  function initTestimonialCarousel($scope) {
    var $carousel = $scope.find('.hmcoders-testimonial-carousel');
    if (!$carousel.length) return;

    $carousel.each(function () {
      var $el = $(this);

      // Merge settings from Elementor
      var settings = $.extend(
        {
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          infinite: false,
          arrows: true,
          pauseOnHover: true,
        },
        $el.data('carousel-settings') || {}
      );

      var $items = $el.find('.hmcoders-testimonial-item');
      var total = $items.length;
      var current = 0;
      var intervalId = null;

      // Wrap items
      $items.wrapAll('<div class="hmcoders-carousel-track"></div>');
      var $track = $el.find('.hmcoders-carousel-track');
      $track.wrap('<div class="hmcoders-carousel-viewport"></div>');

      // Apply widths
      $items.css('width', 100 / settings.slidesToShow + '%');
      $track.css('width', (100 * total) / settings.slidesToShow + '%');

      // Autoplay
      if (settings.autoplay) {
        startAutoplay();
        if (settings.pauseOnHover) {
          $el.hover(stopAutoplay, startAutoplay);
        }
      }

      // Bind arrows (already rendered by PHP)
      if (settings.arrows) {
        $el.on('click', '.prev', prevSlide);
        $el.on('click', '.next', nextSlide);
      }

      update();

      /**
       * Update carousel state
       */
      function update() {
        var maxIndex = Math.max(
          0,
          settings.infinite ? total : total - settings.slidesToShow
        );

        if (current < 0) {
          current = settings.infinite ? total - settings.slidesToScroll : 0;
        }
        if (current > maxIndex) {
          current = settings.infinite ? 0 : maxIndex;
        }

        var translate = -(current * (100 / settings.slidesToShow));
        $track.css('transform', 'translateX(' + translate + '%)');

        // Toggle arrow disabled state
        if (!settings.infinite && settings.arrows) {
          $el.find('.prev').toggleClass('disabled', current === 0);
          $el.find('.next').toggleClass('disabled', current === maxIndex);
        }
      }

      /**
       * Navigation
       */
      function nextSlide() {
        current += settings.slidesToScroll;
        update();
      }
      function prevSlide() {
        current -= settings.slidesToScroll;
        update();
      }

      /**
       * Autoplay control
       */
      function startAutoplay() {
        stopAutoplay();
        intervalId = setInterval(nextSlide, settings.autoplaySpeed);
      }
      function stopAutoplay() {
        clearInterval(intervalId);
      }
    });
  }
})(jQuery);
