<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Hmake_class_Assets {

    const VERSION = '1.0.0';

    /**
     * Register all scripts
     */
       public static function hmake_register_scripts() {
        // wp_register_script(
        //     'hmcoders-dynamic-post-grid-js',
        //     plugins_url( 'assets/js/hmake-dynamic-post-grid.js', HMAKE_PLUGIN_FILE ),
        //     [ 'jquery' ],
        //     self::VERSION,
        //     true
        // );

        // wp_register_script(
        //     'hmcoders-advanced-team-member-js',
        //     plugins_url( 'assets/js/hmake-advanced-team-member.js', HMAKE_PLUGIN_FILE ),
        //     [ 'jquery' ],
        //     self::VERSION,
        //     true
        // );

        wp_register_script(
            'hmcoders-interactive-timeline-js',
            plugins_url( 'assets/js/hmake-interactive-timeline.js', HMAKE_PLUGIN_FILE ),
            [ 'jquery' ],
            self::VERSION,
            true
        );

        // wp_register_script(
        //     'hmcoders-pricing-table-pro-js',
        //     plugins_url( 'assets/js/hmake-pricing-table-pro.js', HMAKE_PLUGIN_FILE ),
        //     [ 'jquery' ],
        //     self::VERSION,
        //     true
        // );

        // wp_register_script(
        //     'hmcoders-testimonial-carousel-js',
        //     plugins_url( 'assets/js/hmake-testimonial-carousel.js', HMAKE_PLUGIN_FILE ),
        //     [ 'jquery' ],
        //     self::VERSION,
        //     true
        // );

        // External AOS script
        wp_register_script(
            'hmake-aos',
            'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js',
            [],
            '2.3.4',
            true
        );
    }
    
    /**
     * Register all styles
    */
    public static function hmake_register_styles() {
        // Font Awesome - from CDN
        // wp_register_style(
        //     'hmcoders-fontawesome',
        //     'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
        //     [],
        //     '5.15.4'
        // );

        // wp_register_style(
        //     'hmcoders-dynamic-post-grid-css',
        //     plugin_dir_url( HMAKE_PLUGIN_FILE ) . 'assets/css/hmake-dynamic-post-grid.css',
        //     [],
        //     self::VERSION
        // );

        // wp_register_style(
        //     'hmcoders-advanced-team-member-css',
        //     plugin_dir_url( HMAKE_PLUGIN_FILE ) . 'assets/css/hmake-advanced-team-member.css',
        //     [],
        //     self::VERSION
        // );
        
        wp_register_style(
            'hmcoders-interactive-timeline-css',
            plugin_dir_url( HMAKE_PLUGIN_FILE ) . 'assets/css/hmake-interactive-timeline.css',
            [],
            self::VERSION
        );

        // wp_register_style(
        //     'hmcoders-pricing-table-pro-css',
        //     plugin_dir_url( HMAKE_PLUGIN_FILE ) . 'assets/css/hmake-pricing-table-pro.css',
        //     [],
        //     self::VERSION
        // );
        
        // wp_register_style(
        //     'hmcoders-testimonial-carousel-css',
        //     plugin_dir_url( HMAKE_PLUGIN_FILE ) . 'assets/css/hmake-testimonial-carousel.css',
        //     [],
        //     self::VERSION
        // );

        // External AOS CSS
        wp_register_style(
            'hmake-aos',
            'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css',
            [],
            '2.3.4'
        );
    }
    
    /**
     * Enqueue scripts by handles array
     *
     * @param array $handles Array of script handles
    */
    public static function enqueue_scripts( $handles = [] ) {
        foreach ( $handles as $handle ) {
            if ( wp_script_is( $handle, 'registered' ) ) {
                wp_enqueue_script( $handle );
            }
        }
    }
    
    /**
     * Enqueue styles by handles array
    *
    * @param array $handles Array of style handles
    */
    public static function enqueue_styles( $handles = [] ) {
        foreach ( $handles as $handle ) {
            if ( wp_style_is( $handle, 'registered' ) ) {
                wp_enqueue_style( $handle );
            }
        }
    }
    
    /**
     * Initialize by registering all scripts and styles
     * Hook this once on 'wp_enqueue_scripts' or early
     */
    public static function init() {
        self::hmake_register_scripts();
        self::hmake_register_styles();

    }
}
