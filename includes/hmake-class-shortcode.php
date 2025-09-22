<?php

namespace hmcoders\Elementor_Addon;
use hmcoders\Elementor_Addon\Hmake_Timeline_Render;

if ( ! defined( 'ABSPATH' ) ) exit;

class Hmake_Shortcodes {

    /**
     * Init all shortcodes
     */
    public static function init() {
        // Register shortcode for Timeline
        add_shortcode( 'hmake_timeline', array( __CLASS__, 'hmake_render_timeline' ) );
    }

    /**
     * Render Timeline shortcode
     *
     * @param array $atts
     * @param string|null $content
     * @return string
     */
    public static function hmake_render_timeline( $atts) {
        // Ensure WP_Query uses global namespace
        return Hmake_Timeline_Render::hmake_timeline_render_widget( $atts );
    }
}

// Initialize shortcodes
Hmake_Shortcodes::init();
