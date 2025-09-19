<?php
if (!defined('ABSPATH')) {
    exit;
}

class Hmake_CPT_Register {

    public function __construct() {
        add_action('init', array($this, 'hmake_register_cpts'));
    }

public function hmake_register_cpts() {
    // Timeline CPT
    register_post_type('hmake_timeline', array(
        'labels' => array(
            'name' => __('Timelines', 'hmcoders'),
            'singular_name' => __('Timeline', 'hmcoders'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'timeline'),
    ));

    // // Team CPT
    // register_post_type('hmceak_team', array(
    //     'labels' => array(
    //         'name' => __('Teams', 'hmcoders'),
    //         'singular_name' => __('Team', 'hmcoders'),
    //     ),
    //     'public' => true,
    //     'supports' => array('title', 'editor', 'thumbnail'),
    //     'has_archive' => true,
    //     'show_in_rest' => true,
    //     'rewrite' => array('slug' => 'team'),
    // ));

    // // Testimonial CPT
    // register_post_type('hmceak_testimonial', array(
    //     'labels' => array(
    //         'name' => __('Testimonials', 'hmcoders'),
    //         'singular_name' => __('Testimonial', 'hmcoders'),
    //     ),
    //     'public' => true,
    //     'supports' => array('title', 'editor', 'thumbnail'),
    //     'has_archive' => true,
    //     'show_in_rest' => true,
    //     'rewrite' => array('slug' => 'testimonial'),
    // ));

    // // Pricing CPT
    // register_post_type('hmceak_pricing', array(
    //     'labels' => array(
    //         'name' => __('Pricings', 'hmcoders'),
    //         'singular_name' => __('Pricing', 'hmcoders'),
    //     ),
    //     'public' => true,
    //     'supports' => array('title', 'editor', 'thumbnail'),
    //     'has_archive' => true,
    //     'show_in_rest' => true,
    //     'rewrite' => array('slug' => 'pricing'),
    // ));
}
}

// Initialize the class
new Hmake_CPT_Register();
