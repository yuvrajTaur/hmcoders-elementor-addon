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

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Hmake_Testimonial_Carousel extends Widget_Base {

    public function get_name() {
        return 'hmake-testimonial-carousel';
    }

    public function get_title() {
        return esc_html__( 'Testimonial Carousel', 'hmcoders-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-testimonial-carousel';
    }

    public function get_categories() {
        return [ 'hmcoders-elements' ];
    }

    public function get_script_depends() {
        return [ 'hmcoders-elementor-addon' ];
    }

    public function get_style_depends() {
        return [ 'hmake-fontawesome' ];
    }

    protected function hmake_register_controls() {

        // === Content Section ===
        $this->start_controls_section(
            'hmceak_content_section',
            [
                'label' => esc_html__( 'Testimonials', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'hmceak_testimonial_content',
            [
                'label'   => esc_html__( 'Testimonial Content', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hmcoders-elementor-addon' ),
                'rows'    => 4,
            ]
        );

        $repeater->add_control(
            'hmceak_client_image',
            [
                'label'   => esc_html__( 'Client Image', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'hmceak_client_name',
            [
                'label'       => esc_html__( 'Client Name', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'John Doe', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'hmceak_client_position',
            [
                'label'       => esc_html__( 'Client Position', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'CEO, Company', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'hmceak_rating',
            [
                'label'   => esc_html__( 'Rating', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 5,
                'min'     => 1,
                'max'     => 5,
                'step'    => 0.1,
            ]
        );

        $this->add_control(
            'hmceak_testimonials',
            [
                'label'       => esc_html__( 'Testimonials', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'hmceak_testimonial_content' => esc_html__( 'This is an amazing service! I highly recommend it to anyone looking for quality and reliability.', 'hmcoders-elementor-addon' ),
                        'hmceak_client_name'         => esc_html__( 'Sarah Johnson', 'hmcoders-elementor-addon' ),
                        'hmceak_client_position'     => esc_html__( 'Marketing Director', 'hmcoders-elementor-addon' ),
                        'hmceak_rating'              => 5,
                    ],
                    [
                        'hmceak_testimonial_content' => esc_html__( 'Outstanding experience from start to finish. The team was professional and delivered exactly what was promised.', 'hmcoders-elementor-addon' ),
                        'hmceak_client_name'         => esc_html__( 'Mike Davis', 'hmcoders-elementor-addon' ),
                        'hmceak_client_position'     => esc_html__( 'Business Owner', 'hmcoders-elementor-addon' ),
                        'hmceak_rating'              => 5,
                    ],
                    [
                        'hmceak_testimonial_content' => esc_html__( 'Great value for money. The results exceeded our expectations and the support was fantastic.', 'hmcoders-elementor-addon' ),
                        'hmceak_client_name'         => esc_html__( 'Emma Wilson', 'hmcoders-elementor-addon' ),
                        'hmceak_client_position'     => esc_html__( 'Project Manager', 'hmcoders-elementor-addon' ),
                        'hmceak_rating'              => 4.5,
                    ],
                ],
                'title_field' => '{{{ hmceak_client_name }}} - {{{ hmceak_client_position }}}',
            ]
        );

        $this->end_controls_section();

        // === Carousel Settings Section ===
        $this->start_controls_section(
            'hmceak_carousel_settings_section',
            [
                'label' => esc_html__( 'Carousel Settings', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hmceak_slides_to_show',
            [
                'label'   => esc_html__( 'Slides to Show', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 6,
            ]
        );

        $this->add_control(
            'hmceak_slides_to_scroll',
            [
                'label'   => esc_html__( 'Slides to Scroll', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 6,
            ]
        );

        $this->add_control(
            'hmceak_autoplay',
            [
                'label'        => esc_html__( 'Autoplay', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmceak_autoplay_speed',
            [
                'label'     => esc_html__( 'Autoplay Speed (ms)', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3000,
                'min'       => 1000,
                'max'       => 10000,
                'step'      => 100,
                'condition' => [
                    'hmceak_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hmceak_infinite',
            [
                'label'        => esc_html__( 'Infinite Loop', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmceak_show_dots',
            [
                'label'        => esc_html__( 'Show Dots', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmceak_show_arrows',
            [
                'label'        => esc_html__( 'Show Arrows', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmceak_pause_on_hover',
            [
                'label'        => esc_html__( 'Pause on Hover', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'hmceak_autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function hmake_render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['hmceak_testimonials'] ) ) {
            return;
        }

        $carousel_settings = [
            'slidesToShow'   => absint( $settings['hmceak_slides_to_show'] ),
            'slidesToScroll' => absint( $settings['hmceak_slides_to_scroll'] ),
            'autoplay'       => ( 'yes' === $settings['hmceak_autoplay'] ),
            'autoplaySpeed'  => absint( $settings['hmceak_autoplay_speed'] ),
            'infinite'       => ( 'yes' === $settings['hmceak_infinite'] ),
            'dots'           => ( 'yes' === $settings['hmceak_show_dots'] ),
            'arrows'         => ( 'yes' === $settings['hmceak_show_arrows'] ),
            'pauseOnHover'   => ( 'yes' === $settings['hmceak_pause_on_hover'] ),
        ];

        $this->add_render_attribute('carousel', 'data-carousel-settings',wp_json_encode( $carousel_settings ));
        ?>
        <div class="hmcoders-testimonial-carousel" <?php echo esc_attr( $this->get_render_attribute_string( 'carousel' ) ); ?>>
        <?php foreach ( $settings['hmceak_testimonials'] as $testimonial ) : ?>
            <div class="hmcoders-testimonial-item">
                <?php if ( ! empty( $testimonial['hmceak_testimonial_content'] ) ) : ?>
                    <div class="hmcoders-testimonial-content">
                        <p><?php echo esc_html( $testimonial['hmceak_testimonial_content'] ); ?></p>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $testimonial['hmceak_rating'] ) ) : ?>
                    <div class="hmcoders-rating">
                        <?php
                        $rating      = floatval( $testimonial['hmceak_rating'] );
                        $full_stars  = floor( $rating );
                        $half_star   = ( $rating - $full_stars ) >= 0.5 ? 1 : 0;
                        $empty_stars = 5 - $full_stars - $half_star;

                        for ( $i = 0; $i < $full_stars; $i++ ) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        if ( $half_star ) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }
                        for ( $i = 0; $i < $empty_stars; $i++ ) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <div class="hmcoders-client-info">
                    <div class="hmcoders-client-details">
                        <?php if ( ! empty( $testimonial['hmceak_client_image']['url'] ) ) : ?>
                            <div class="hmcoders-client-image">
                                <img src="<?php echo esc_url( $testimonial['hmceak_client_image']['url'] ); ?>" alt="<?php echo esc_attr( $testimonial['hmceak_client_name'] ); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="hmcoders-client-text">
                            <?php if ( ! empty( $testimonial['hmceak_client_name'] ) ) : ?>
                                <h4 class="hmcoders-client-name"><?php echo esc_html( $testimonial['hmceak_client_name'] ); ?></h4>
                            <?php endif; ?>

                            <?php if ( ! empty( $testimonial['hmceak_client_position'] ) ) : ?>
                                <div class="hmcoders-client-position"><?php echo esc_html( $testimonial['hmceak_client_position'] ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

        <?php
    }

    protected function hmake_content_template() {}
}
