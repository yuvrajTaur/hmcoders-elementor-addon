<?php
/**
 * Plugin Name: Hmake Elementor Addons
 * Description: A comprehensive Elementor addon with 5 dynamic widgets for enhanced page building.
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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants for path and URL.
define( 'HMCODERS_PATH', plugin_dir_path( __FILE__ ) );
define( 'HMCODERS_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'HMAKE_PLUGIN_FILE' ) ) {
    define( 'HMAKE_PLUGIN_FILE', __FILE__ );
}

// Main plugin class
final class Hmake_Elementor_Addon {

    // Plugin and compatibility constants
    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.4';

    private static $_instance = null;

    /**
     * Singleton instance
     */
    public static function hmake_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor - Hooks setup
     */
    public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'hmake_on_plugins_loaded' ] );
        // Include files and setup translations
        $this->hmake_includes();
        add_action( 'init', [ $this, 'hmake_load_textdomain' ] );
    }

    /**
     * Check Elementor and PHP compatibility
     */
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

    /* --- Admin Notices for Compatibility --- */
    public function hmake_admin_notice_missing_main_plugin() {
        $activate = filter_input( INPUT_GET, 'activate', FILTER_SANITIZE_STRING );
        if ( $activate ) unset( $_GET['activate'] );
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
        if ( $activate ) unset( $_GET['activate'] );
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
        $activate = filter_input( INPUT_GET, 'activate', FILTER_SANITIZE_STRING );
        if ( $activate ) unset( $_GET['activate'] );
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

    /**
     * Triggered when all plugins loaded - Initialize after Elementor loads
     */
    public function hmake_on_plugins_loaded() {
        if ( did_action( 'elementor/loaded' ) ) {
            add_action( 'elementor/init', [ $this, 'hmake_init' ] );
        }
    }

    /**
     * Register custom widget category and widgets
     */
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

        // Register dynamic widgets
        add_action( 'elementor/widgets/register', [ $this, 'hmake_register_widgets' ] );
    } 

    /**
     * Load plugin translation files
     */
    public function hmake_load_textdomain() {
        load_plugin_textdomain( 'hmcoders-elementor-addon', false, basename(dirname(__FILE__)) . '/languages' );
    }

    /**
     * Include required files and enqueue scripts/styles
     */
    public function hmake_includes() {
        // Asset and helper classes and custom post types
        add_action( 'wp_enqueue_scripts', function() {
            Hmake_class_Assets::init();
            // Enqueue all required styles
            Hmake_class_Assets::enqueue_styles([
                'hmcoders-fontawesome',
                'hmcoders-dynamic-post-grid-css',
                'hmcoders-advanced-team-member-css',
                'hmcoders-interactive-timeline-css',
                'hmcoders-pricing-table-pro-css',
                'hmcoders-testimonial-carousel-css',
                'hmake-aos',
            ]);
            // Enqueue all required scripts
            Hmake_class_Assets::enqueue_scripts([
                'hmcoders-dynamic-post-grid-js',
                'hmcoders-advanced-team-member-js',
                'hmcoders-interactive-timeline-js',
                'hmcoders-pricing-table-pro-js',
                'hmcoders-testimonial-carousel-js',
                'hmake-aos',
            ]);
        });

        // Core plugin functionality includes
        require_once HMCODERS_PATH . 'includes/hmake-class-cpt.php';
        require_once HMCODERS_PATH . 'includes/hmake-class-helper.php';
        require_once HMCODERS_PATH . 'includes/hmake-class-shortcode.php';
        require_once HMCODERS_PATH . 'includes/hmake-class-assets.php';
    }

    /**
     * Register each widget with Elementor
     */
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
}

// Initialize the main plugin class on load
Hmake_Elementor_Addon::hmake_instance();
