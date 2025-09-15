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
 * Interactive Timeline Widget
 *
 * Elementor widget for hmcoders Interactive Timeline.
 *
 * @since 1.0.0
 */
class Hmake_Interactive_Timeline extends Widget_Base {

    public function get_name() {
        return 'hmcoders-interactive-timeline';
    }

    public function get_title() {
        return esc_html__( 'Interactive Timeline', 'hmcoders-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'hmcoders-elements' ];
    }

    public function get_script_depends() {
        return [ 'hmcoders-elementor-addon' ];
    }

    protected function register_controls() {
        // === Timeline Items Section ===
        $this->start_controls_section(
            'hmake_content_section',
            [
                'label' => esc_html__( 'Timeline Items', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'hmake_item_date',
            [
                'label'       => esc_html__( 'Date', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '2024', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( '2024', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'hmake_item_icon',
            [
                'label'   => esc_html__( 'Icon', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-calendar-alt',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'hmake_item_title',
            [
                'label'       => esc_html__( 'Title', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Timeline Item', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter title', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'hmake_item_description',
            [
                'label'   => esc_html__( 'Description', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hmcoders-elementor-addon' ),
                'rows'    => 4,
            ]
        );

        $repeater->add_control(
            'hmake_item_image',
            [
                'label'       => esc_html__( 'Image (Optional)', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::MEDIA,
                'description' => esc_html__( 'Optional image to display with the timeline item', 'hmcoders-elementor-addon' ),
            ]
        );

        $repeater->add_control(
            'hmake_item_link',
            [
                'label'       => esc_html__( 'Link (Optional)', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'hmcoders-elementor-addon' ),
                'description' => esc_html__( 'Optional link for the timeline item', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->add_control(
            'hmake_timeline_items',
            [
                'label'       => esc_html__( 'Timeline Items', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'hmake_item_date'        => esc_html__( '2020', 'hmcoders-elementor-addon' ),
                        'hmake_item_title'       => esc_html__( 'Company Founded', 'hmcoders-elementor-addon' ),
                        'hmake_item_description' => esc_html__( 'Our journey began with a simple idea and a passion for innovation.', 'hmcoders-elementor-addon' ),
                    ],
                    [
                        'hmake_item_date'        => esc_html__( '2021', 'hmcoders-elementor-addon' ),
                        'hmake_item_title'       => esc_html__( 'First Product Launch', 'hmcoders-elementor-addon' ),
                        'hmake_item_description' => esc_html__( 'We launched our first product after months of development and testing.', 'hmcoders-elementor-addon' ),
                    ],
                ],
                'title_field' => '{{{ hmake_item_date }}} - {{{ hmake_item_title }}}',
            ]
        );

        $this->end_controls_section();

        // === Layout Section ===
        $this->start_controls_section(
            'hmake_layout_section',
            [
                'label' => esc_html__( 'Layout', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hmake_timeline_layout',
            [
                'label'   => esc_html__( 'Layout', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical'   => esc_html__( 'Vertical', 'hmcoders-elementor-addon' ),
                    'horizontal' => esc_html__( 'Horizontal', 'hmcoders-elementor-addon' ),
                ],
            ]
        );

        $this->add_control(
            'hmake_timeline_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'   => esc_html__( 'Left', 'hmcoders-elementor-addon' ),
                    'right'  => esc_html__( 'Right', 'hmcoders-elementor-addon' ),
                    'center' => esc_html__( 'Center (Alternating)', 'hmcoders-elementor-addon' ),
                ],
                'condition' => [
                    'hmake_timeline_layout' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'hmake_show_animation',
            [
                'label'        => esc_html__( 'Show Animation', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => esc_html__( 'Enable scroll-based animation effects', 'hmcoders-elementor-addon' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['hmake_timeline_items'] ) || ! is_array( $settings['hmake_timeline_items'] ) ) {
            return;
        }

        $layout    = $settings['hmake_timeline_layout'] ?? 'vertical';
        $alignment = $settings['hmake_timeline_alignment'] ?? 'left';
        $animated  = ( isset( $settings['hmake_show_animation'] ) && 'yes' === $settings['hmake_show_animation'] );

        $timeline_class  = 'hmcoders-timeline-' . $layout;
        $timeline_class .= ' hmcoders-timeline-' . $alignment;

        if ( $animated ) {
            $timeline_class .= ' hmcoders-timeline-animated';
        }
        ?>
        <div class="hmcoders-timeline-wrapper <?php echo esc_attr( $timeline_class ); ?>">
            <div class="hmcoders-timeline-line"></div>

            <?php foreach ( $settings['hmake_timeline_items'] as $index => $item ) :
                $item_alignment = $alignment;
                if ( 'center' === $alignment ) {
                    $item_alignment = ( (int) $index % 2 === 0 ) ? 'left' : 'right';
                }

                $item_position = in_array( $item_alignment, [ 'left', 'right' ], true ) ? $item_alignment : 'left';
                $item_class    = 'hmcoders-timeline-item hmcoders-timeline-' . $item_position;

                $link_tag = 'div'; // default fallback
                $link_attributes = '';

                if ( ! empty( $item['hmake_item_link']['url'] ) ) {
                    $link_tag = 'a';
                    $attrs   = [];

                    // Escape URL
                    $attrs[] = 'href="' . esc_url( $item['hmake_item_link']['url'] ) . '"';

                    // Add target
                    if ( ! empty( $item['hmake_item_link']['is_external'] ) ) {
                        $attrs[] = 'target="_blank"';
                    }

                    // Add nofollow
                    if ( ! empty( $item['hmake_item_link']['nofollow'] ) ) {
                        $attrs[] = 'rel="nofollow"';
                    }

                    // Implode attributes
                    $link_attributes = implode( ' ', $attrs );
                }

                $aos_direction = ( $item_position === 'right' ) ? 'left' : 'right';
                $aos_value     = 'fade-' . $aos_direction;
                ?>
                <div class="<?php echo esc_attr( $item_class ); ?>" data-aos="<?php echo esc_attr( $aos_value ); ?>">
                    <div class="hmcoders-timeline-marker">
                        <div class="hmcoders-timeline-icon">
                            <?php
                            if ( ! empty( $item['hmake_item_icon'] ) ) {
                                Icons_Manager::render_icon( $item['hmake_item_icon'], [ 'aria-hidden' => 'true' ] );
                            }
                            ?>
                        </div>
                    </div>

                    <<?php echo esc_attr( $link_tag ); ?> 
                    class="hmcoders-timeline-content" 
    <?php echo wp_kses_post( $link_attributes ); ?>>
                        <?php if ( ! empty( $item['hmake_item_date'] ) ) : ?>
                            <div class="hmcoders-timeline-date"><?php echo esc_html( $item['hmake_item_date'] ); ?></div>
                        <?php endif; ?>

                        <?php if ( ! empty( $item['hmake_item_image']['url'] ) ) : ?>
                            <div class="hmcoders-timeline-image">
                                <img src="<?php echo esc_url( $item['hmake_item_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['hmake_item_title'] ?? '' ); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $item['hmake_item_title'] ) ) : ?>
                            <h3 class="hmcoders-timeline-title"><?php echo esc_html( $item['hmake_item_title'] ); ?></h3>
                        <?php endif; ?>

                        <?php if ( ! empty( $item['hmake_item_description'] ) ) : ?>
                            <div class="hmcoders-timeline-description">
                                <p><?php echo wp_kses_post( $item['hmake_item_description'] ); ?></p>
                            </div>
                        <?php endif; ?>
                    </<?php echo esc_attr( $link_tag ); ?>>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() {}
}
