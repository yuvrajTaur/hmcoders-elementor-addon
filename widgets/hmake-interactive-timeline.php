<?php
namespace hmcoders\Elementor_Addon;
use hmcoders\Elementor_Addon\Hmake_Timeline_Render;
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

    public function get_style_depends() {
        return [ 'hmcoders-fontawesome', 'hmcoders-interactive-timeline-css', 'hmcoders-aos' ];
    }
    
    public function get_script_depends() {
        return [ 'hmcoders-interactive-timeline-js', 'hmcoders-aos' ];
    }

    protected function register_controls() {

        // === Layout Section ===
        $this->start_controls_section(
            'hmceak_layout_section',
            [
                'label' => esc_html__( 'Layout', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hmceak_timeline_layout',
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
            'hmceak_timeline_alignment',
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
                    'hmceak_timeline_layout' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'hmceak_show_animation',
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

    // In your Elementor widget render method
    protected function render() {
        $settings = $this->get_settings_for_display();
        echo Hmake_Timeline_Render::hmake_timeline_render_widget($settings);
    }
}
