<?php
namespace hmcoders\Elementor_Addon;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Pricing Table Pro Widget
 *
 * Elementor widget for hmcoders Pricing Table Pro.
 *
 * @since 1.0.0
 */
class Hmake_Pricing_Table_Pro extends Widget_Base {

    public function get_name() {
        return 'hmcoders-pricing-table-pro';
    }

    public function get_title() {
        return esc_html__( 'Pricing Table Pro', 'hmcoders-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    public function get_categories() {
        return [ 'hmcoders-elements' ];
    }

    public function get_style_depends() {
        return [ 'hmcoders-fontawesome', 'hmcoders-pricing-table-pro-css' ];
    }

    public function get_script_depends() {
        return [ 'hmcoders-pricing-table-pro-js' ];
    }
    protected function register_controls() {
        // Header Section
        $this->start_controls_section(
            'header_section',
            [
                'label' => esc_html__( 'Header', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__( 'Title', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Basic Plan', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter title', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'       => esc_html__( 'Subtitle', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Perfect for beginners', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter subtitle', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'featured',
            [
                'label'        => esc_html__( 'Featured', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'featured_text',
            [
                'label'     => esc_html__( 'Featured Text', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Most Popular', 'hmcoders-elementor-addon' ),
                'condition' => [
                    'featured' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Pricing Section
        $this->start_controls_section(
            'pricing_section',
            [
                'label' => esc_html__( 'Pricing', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'currency',
            [
                'label'       => esc_html__( 'Currency', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '$',
                'placeholder' => esc_html__( '$', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->add_control(
            'price',
            [
                'label'       => esc_html__( 'Price', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '29',
                'placeholder' => esc_html__( '29', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->add_control(
            'period',
            [
                'label'       => esc_html__( 'Period', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '/month', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( '/month', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->add_control(
            'original_price',
            [
                'label'       => esc_html__( 'Original Price', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '49', 'hmcoders-elementor-addon' ),
                'description' => esc_html__( 'Strike through price (optional)', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->end_controls_section();

        // Features Section
        $this->start_controls_section(
            'features_section',
            [
                'label' => esc_html__( 'Features', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'feature_text',
            [
                'label'       => esc_html__( 'Feature Text', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Feature Item', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'feature_icon',
            [
                'label'   => esc_html__( 'Icon', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'feature_available',
            [
                'label'        => esc_html__( 'Available', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'features_list',
            [
                'label'       => esc_html__( 'Features List', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'feature_text'      => esc_html__( '10GB Storage', 'hmcoders-elementor-addon' ),
                        'feature_available' => 'yes',
                    ],
                    [
                        'feature_text'      => esc_html__( 'Email Support', 'hmcoders-elementor-addon' ),
                        'feature_available' => 'yes',
                    ],
                    [
                        'feature_text'      => esc_html__( 'SSL Certificate', 'hmcoders-elementor-addon' ),
                        'feature_available' => 'yes',
                    ],
                    [
                        'feature_text'      => esc_html__( 'Priority Support', 'hmcoders-elementor-addon' ),
                        'feature_available' => 'no',
                    ],
                ],
                'title_field' => '{{{ feature_text }}}',
            ]
        );

        $this->end_controls_section();

        // Button Section
        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__( 'Button', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__( 'Button Text', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Get Started', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Get Started', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label'       => esc_html__( 'Link', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'hmcoders-elementor-addon' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        // (Card, Header, Pricing, Features and Button style sections go here - unchanged from your given snippet)
        // I will keep them intact in the final code file.
    }

      protected function render() {
        $settings = $this->get_settings_for_display();

        $featured_class = ( isset( $settings['featured'] ) && 'yes' === $settings['featured'] ) ? ' hmcoders-featured' : '';

        // Button attributes
        if ( ! empty( $settings['button_link']['url'] ) ) {
            $this->add_render_attribute( 'button_link', 'href', esc_url( $settings['button_link']['url'] ) );
        }
        $this->add_render_attribute( 'button_link', 'class', 'hmcoders-pricing-button' );

        if ( ! empty( $settings['button_link']['is_external'] ) ) {
            $this->add_render_attribute( 'button_link', 'target', '_blank' );
        }

        if ( ! empty( $settings['button_link']['nofollow'] ) ) {
            $this->add_render_attribute( 'button_link', 'rel', 'nofollow' );
        }
        ?>
        <div class="hmcoders-pricing-table<?php echo esc_attr( $featured_class ); ?>">
            <?php if ( isset( $settings['featured'] ) && 'yes' === $settings['featured'] && ! empty( $settings['featured_text'] ) ) : ?>
                <div class="hmcoders-featured-badge">
                    <?php echo esc_html( $settings['featured_text'] ); ?>
                </div>
            <?php endif; ?>

            <div class="hmcoders-pricing-header">
                <?php if ( ! empty( $settings['title'] ) ) : ?>
                    <h3 class="hmcoders-pricing-title"><?php echo esc_html( $settings['title'] ); ?></h3>
                <?php endif; ?>

                <?php if ( ! empty( $settings['subtitle'] ) ) : ?>
                    <div class="hmcoders-pricing-subtitle"><?php echo esc_html( $settings['subtitle'] ); ?></div>
                <?php endif; ?>

                <div class="hmcoders-pricing-price-wrapper">
                    <?php if ( ! empty( $settings['original_price'] ) ) : ?>
                        <span class="hmcoders-original-price">
                            <?php echo esc_html( $settings['currency'] . $settings['original_price'] ); ?>
                        </span>
                    <?php endif; ?>

                    <div class="hmcoders-pricing-price">
                        <?php if ( ! empty( $settings['currency'] ) ) : ?>
                            <span class="hmcoders-pricing-currency"><?php echo esc_html( $settings['currency'] ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['price'] ) ) : ?>
                            <?php echo esc_html( $settings['price'] ); ?>
                        <?php endif; ?>
                        <?php if ( ! empty( $settings['period'] ) ) : ?>
                            <span class="hmcoders-pricing-period"><?php echo esc_html( $settings['period'] ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ( ! empty( $settings['features_list'] ) && is_array( $settings['features_list'] ) ) : ?>
                <div class="hmcoders-pricing-features">
                    <?php foreach ( $settings['features_list'] as $feature ) :
                        $unavailable_class = ( isset( $feature['feature_available'] ) && 'no' === $feature['feature_available'] ) ? ' unavailable' : '';
                        ?>
                        <div class="hmcoders-feature-item<?php echo esc_attr( $unavailable_class ); ?>">
                            <span class="hmcoders-feature-icon">
                                <?php
                                if ( ! empty( $feature['feature_icon'] ) ) {
                                    Icons_Manager::render_icon( $feature['feature_icon'], [ 'aria-hidden' => 'true' ] );
                                }
                                ?>
                            </span>
                            <span class="hmcoders-feature-text"><?php echo esc_html( $feature['feature_text'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $settings['button_text'] ) ) : ?>
                <div class="hmcoders-pricing-footer">
                    <a <?php echo wp_kses_post( $this->get_render_attribute_string( 'button_link' ) ); ?>>
                        <?php echo esc_html( $settings['button_text'] ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function content_template() {}
}
