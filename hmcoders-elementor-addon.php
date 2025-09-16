<?php
/**
 * Plugin Name: Hmake Elementor Addons  
 * Description: A comprehensive Elementor addon with 5 dynamic widgets for enhanced page building
 * Plugin URI: https://hmcoders.com/elementor-addon
 * Author: hmcoders
 * Version: 1.0.0
 * Author URI: https://hmcoders.com
 * Text Domain: hmcoders-elementor-addon
 * Domain Path: /languages
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class Hmake_Elementor_Addon {

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.4';

    private static $_instance = null;

    public static function hmake_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        // if ( $this->hmake_is_compatible() ) {
            add_action( 'plugins_loaded', [ $this, 'hmake_on_plugins_loaded' ] );
            // Load plugin textdomain
            add_action( 'init', [ $this, 'hmake_load_textdomain' ] );
        // }
    }

    public function hmake_is_compatible() {
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'hmake_admin_notice_missing_main_plugin' ] );
            return false;
        }
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'hmake_admin_notice_minimum_elementor_version' ] );
            return false;
        }
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'hmake_admin_notice_minimum_php_version' ] );
            return false;
        }
        return true;
    }

    public function hmake_admin_notice_missing_main_plugin() {
        $activate = filter_input( INPUT_GET, 'activate', FILTER_SANITIZE_STRING );
        if ( $activate ) {
            unset( $_GET['activate'] );
        }

        /* translators: 1: Plugin name, 2: Required plugin name */
        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            sprintf(
                esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'hmcoders-elementor-addon' ),
                '<strong>' . esc_html__( 'Hmake Elementor Addon', 'hmcoders-elementor-addon' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'hmcoders-elementor-addon' ) . '</strong>'
            )
        );
    }


    public function hmake_admin_notice_minimum_elementor_version() {
        
        $activate = filter_input( INPUT_GET, 'activate', FILTER_SANITIZE_STRING );
        if ( $activate ) {
            unset( $_GET['activate'] );
        }

        /* translators: 1: Plugin name, 2: Elementor, 3: Minimum Elementor version */
        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            sprintf(
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hmcoders-elementor-addon' ),
                '<strong>' . esc_html__( 'Hmake Elementor Addon', 'hmcoders-elementor-addon' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'hmcoders-elementor-addon' ) . '</strong>',
                esc_html( self::MINIMUM_ELEMENTOR_VERSION )
            )
        );
    }



    public function hmake_admin_notice_minimum_php_version() {
        // Sanitize the 'activate' GET parameter
        $activate = filter_input( INPUT_GET, 'activate', FILTER_SANITIZE_STRING );
        if ( $activate ) {
            unset( $_GET['activate'] );
        }

        /* translators: 1: Plugin name, 2: PHP, 3: Minimum PHP version */
        printf(
            '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
            sprintf(
                esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hmcoders-elementor-addon' ),
                '<strong>' . esc_html__( 'Hmake Elementor Addon', 'hmcoders-elementor-addon' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'hmcoders-elementor-addon' ) . '</strong>',
                esc_html( self::MINIMUM_PHP_VERSION )
            )
        );
    }


    public function hmake_on_plugins_loaded() {
        if ( did_action( 'elementor/loaded' ) ) {
            add_action( 'elementor/init', [ $this, 'hmake_init' ] );
        }
    }

    public function hmake_init() {
       
        // Register widget category
        add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
            $elements_manager->add_category(
                'hmcoders-elements',
                [
                    'title' => __( 'HMCoders Elements', 'hmcoders-elementor-addon' ),
                    'icon'  => 'fa fa-plug',
                ]
            );
        });

        // Register widgets
        add_action( 'elementor/widgets/register', [ $this, 'hmake_register_widgets' ] );

        // Enqueue styles and scripts
        add_action( 'wp_enqueue_scripts', [ $this, 'hmake_widget_scripts' ] );
        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'hmake_enqueue_styles' ] );

   
    }

        public function hmake_load_textdomain() {
            
            load_plugin_textdomain('hmake-elementor-addon',false,basename( dirname( __FILE__ ) ) . '/languages');
        }

        public function hmake_register_widgets( $widgets_manager ) {
            $widgets = [
                'hmake-dynamic-post-grid'    => 'Hmake_Dynamic_Post_Grid',
                'hmake-advanced-team-member' => 'Hmake_Advanced_Team_Member',
                'hmake-pricing-table-pro'    => 'Hmake_Pricing_Table_Pro',
                'hmake-testimonial-carousel' => 'Hmake_Testimonial_Carousel',
                'hmake-interactive-timeline' => 'Hmake_Interactive_Timeline',
            ];

            foreach ( $widgets as $file_slug => $class ) {
                $file = __DIR__ . '/widgets/' . $file_slug . '.php';
                if ( file_exists( $file ) ) {
                    require_once $file;
                    $fqcn = "\\hmcoders\\Elementor_Addon\\{$class}";
                    if ( class_exists( $fqcn ) ) {
                        $widgets_manager->register( new $fqcn() );
                    }
                   
                }
                
            }
        }


    public function hmake_widget_scripts() {
        wp_register_script(
            'hmcoders-elementor-addon-script', // Updated handle to match widgets
            plugins_url( 'assets/js/frontend.js', __FILE__ ),
            [ 'jquery' ],
            self::VERSION,
            true
        );
        wp_enqueue_script( 'hmcoders-elementor-addon-script' );
    }

    public function hmake_enqueue_styles() {
        
        // wp_enqueue_style(
        //     'hmcoders-fontawesome',
        //     plugin_dir_url( __FILE__ ) . 'assets/font/hmake-fontawesome.css',
        //     [],
        //     self::VERSION
        // );
            
        wp_enqueue_style(
    'hmcoders-fontawesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
    [],
    '5.15.4'
);

        wp_enqueue_style(
            'hmcoders-dynamic-post-grid',
            plugin_dir_url( __FILE__ ) . 'assets/css/hmake-dynamic-post-grid.css',
            [],
            self::VERSION
        );
        wp_enqueue_style(
            'hmcoders-advanced-team-member',
            plugin_dir_url( __FILE__ ) . 'assets/css/hmake-advanced-team-member.css',
            [],
            self::VERSION
        );
        wp_enqueue_style(
            'hmcoders-interactive-timeline',
            plugin_dir_url( __FILE__ ) . 'assets/css/hmake-interactive-timline.css',
            [],
            self::VERSION
        );
        wp_enqueue_style(
            'hmcoders-pricing-table-pro',
            plugin_dir_url( __FILE__ ) . 'assets/css/hmake-pricing-table-pro.css',
            [],
            self::VERSION
        );
        wp_enqueue_style(
            'hmcoders-testimonial-carousel',
            plugin_dir_url( __FILE__ ) . 'assets/css/hmake-testimonial-carousel.css',
            [],
            self::VERSION
        );

        wp_enqueue_style(
            'hmake-aos',
            'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css',
            [],
            '2.3.4'
        );

        wp_enqueue_script(
            'hmake-aos',
            'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js',
            [],
            '2.3.4',
            true
        );
    }
}

// Initialize plugin
Hmake_Elementor_Addon::hmake_instance();
