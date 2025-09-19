<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Hmake_Shortcodes {

    /**
     * Init all shortcodes
     */
    public static function init() {
        // Register Timeline shortcode
        add_shortcode( 'hmake_timeline', [ __CLASS__, 'hmake_render_timeline' ] );
    }

    /**
     * Render Timeline shortcode
     *
     * @param array $atts
     * @return string
     */
    public static function hmake_render_timeline( $atts ) {
        // call helper render function
        return Hmake_Helper::hmake_render_timeline( $atts );
    }
}

// Initialize shortcodes
Hmake_Shortcodes::init();
