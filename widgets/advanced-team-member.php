<?php
namespace hmcoders\Elementor_Addon;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Advanced Team Member Widget
 *
 * Elementor widget for hmcoders Advanced Team Member.
 *
 * @since 1.0.0
 */
class Hmake_Advanced_Team_Member extends Widget_Base {

    public function get_name() {
        return 'hmake_advanced_team_member';
    }

    public function get_title() {
        return esc_html__( 'Advanced Team Member', 'hmcoders-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
        return [ 'hmcoders-elements' ];
    }

    public function get_script_depends() {
        return [ 'hmcoders-elementor-addon' ];
    }

    protected function register_controls() {
        // === CONTENT SECTION ===
        $this->start_controls_section(
            'hmceak_content_section',
            [
                'label' => esc_html__( 'Team Member', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hmceak_image',
            [
                'label'   => esc_html__( 'Choose Image', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'hmceak_name',
            [
                'label'       => esc_html__( 'Name', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'John Doe', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter member name', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'hmceak_position',
            [
                'label'       => esc_html__( 'Position', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Web Developer', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter position', 'hmcoders-elementor-addon' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'hmceak_description',
            [
                'label'       => esc_html__( 'Description', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'hmcoders-elementor-addon' ),
                'placeholder' => esc_html__( 'Enter description', 'hmcoders-elementor-addon' ),
                'rows'        => 4,
            ]
        );

        $this->add_control(
            'hmceak_layout_style',
            [
                'label'   => esc_html__( 'Layout Style', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__( 'Style 1', 'hmcoders-elementor-addon' ),
                    '2' => esc_html__( 'Style 2', 'hmcoders-elementor-addon' ),
                    '3' => esc_html__( 'Style 3', 'hmcoders-elementor-addon' ),
                ],
            ]
        );

        // === SOCIAL LINKS ===
        $this->add_control(
            'hmceak_social_links_heading',
            [
                'label'     => esc_html__( 'Social Links', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'hmceak_social_icon',
            [
                'label'   => esc_html__( 'Icon', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fab fa-facebook-f',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'hmceak_social_link',
            [
                'label'       => esc_html__( 'Link', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'hmcoders-elementor-addon' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        $repeater->add_control(
            'hmceak_social_color',
            [
                'label'     => esc_html__( 'Color', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hmceak_social_links',
            [
                'label'       => esc_html__( 'Social Links', 'hmcoders-elementor-addon' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'hmceak_social_icon' => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ],
                        'hmceak_social_link' => [ 'url' => '#' ],
                    ],
                    [
                        'hmceak_social_icon' => [ 'value' => 'fab fa-twitter', 'library' => 'fa-brands' ],
                        'hmceak_social_link' => [ 'url' => '#' ],
                    ],
                    [
                        'hmceak_social_icon' => [ 'value' => 'fab fa-linkedin-in', 'library' => 'fa-brands' ],
                        'hmceak_social_link' => [ 'url' => '#' ],
                    ],
                ],
                'title_field' => '<# if ( hmceak_social_icon && hmceak_social_icon.value ) { #><i class="{{ hmceak_social_icon.value }}"></i><# } #>',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_class = 'hmcoders-team-' . sanitize_html_class( $settings['hmceak_layout_style'] );
        ?>
        <div class="hmcoders-team-member <?php echo esc_attr( $layout_class ); ?>">
           <?php if ( ! empty( $settings['hmceak_image']['url'] ) ) : ?>
            <div class="hmcoders-team-image">
                <img 
                    src="<?php echo esc_url( $settings['hmceak_image']['url'] ); ?>" 
                    alt="<?php echo esc_attr( $settings['hmceak_name'] ?? '' ); ?>" 
                />
            </div>
        <?php endif; ?>

            <div class="hmcoders-team-content">
                <?php if ( ! empty( $settings['hmceak_name'] ) ) : ?>
                    <h3 class="hmcoders-team-name"><?php echo esc_html( $settings['hmceak_name'] ); ?></h3>
                <?php endif; ?>

                <?php if ( ! empty( $settings['hmceak_position'] ) ) : ?>
                    <div class="hmcoders-team-position">
                        <?php echo esc_html( $settings['hmceak_position'] ); ?>
                    </div>
                <?php endif; ?>


                <?php if ( ! empty( $settings['hmceak_description'] ) ) : ?>
                    <div class="hmcoders-team-description"><?php echo esc_html( $settings['hmceak_description'] ); ?></div>
                <?php endif; ?>

                <?php if ( ! empty( $settings['hmceak_social_links'] ) ) : ?>
                    <div class="hmcoders-social-links">
                        <?php foreach ( $settings['hmceak_social_links'] as $index => $item ) :
                            $social_key = $this->get_repeater_setting_key( 'hmceak_social_link', 'hmceak_social_links', $index );
                            $this->add_render_attribute( $social_key, 'href', esc_url( $item['hmceak_social_link']['url'] ) );

                            if ( ! empty( $item['hmceak_social_link']['is_external'] ) ) {
                                $this->add_render_attribute( $social_key, 'target', '_blank' );
                            }
                            if ( ! empty( $item['hmceak_social_link']['nofollow'] ) ) {
                                $this->add_render_attribute( $social_key, 'rel', 'nofollow' );
                            }
                            ?>
                            <a <?php echo wp_kses_post( $this->get_render_attribute_string( $social_key ) ); ?> 
                            class="elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
                                <?php 
                                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                Icons_Manager::render_icon( $item['hmceak_social_icon'], [ 'aria-hidden' => 'true' ] ); 
                                ?>
                            </a>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {}
}
