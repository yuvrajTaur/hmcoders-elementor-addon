<?php
namespace hmcoders\Elementor_Addon;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Dynamic Post Grid Widget
 *
 * Elementor widget for hmcoders Dynamic Post Grid.
 *
 * @since 1.0.0
 */
class Hmake_Dynamic_Post_Grid extends Widget_Base {

    public function get_name() {
        return 'hmcoders-dynamic-post-grid';
    }

    public function get_title() {
        return esc_html__( 'Dynamic Post Grid', 'hmcoders-elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'hmcoders-elements' ];
    }

    public function get_style_depends() {
        return [ 'hmcoders-fontawesome', 'hmcoders-dynamic-post-grid-css' ];
    }

    public function get_script_depends() {
        return [ 'hmcoders-dynamic-post-grid-js' ];
    }

    protected function register_controls() {
        // === CONTENT SECTION ===
        $this->start_controls_section(
            'hmcodpg_content_section',
            [
                'label' => esc_html__( 'Post Settings', 'hmcoders-elementor-addon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'hmcodpg_posts_per_page',
            [
                'label'   => esc_html__( 'Posts Per Page', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 20,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'hmcodpg_post_type',
            [
                'label'   => esc_html__( 'Post Type', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $this->hmcodpg_get_post_types(),
            ]
        );

        $this->add_control(
            'hmcodpg_columns',
            [
                'label'   => esc_html__( 'Columns', 'hmcoders-elementor-addon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__( '1 Column', 'hmcoders-elementor-addon' ),
                    '2' => esc_html__( '2 Columns', 'hmcoders-elementor-addon' ),
                    '3' => esc_html__( '3 Columns', 'hmcoders-elementor-addon' ),
                    '4' => esc_html__( '4 Columns', 'hmcoders-elementor-addon' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .hmcoders-post-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'hmcodpg_show_image',
            [
                'label'        => esc_html__( 'Show Featured Image', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmcodpg_show_title',
            [
                'label'        => esc_html__( 'Show Title', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmcodpg_show_excerpt',
            [
                'label'        => esc_html__( 'Show Excerpt', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmcodpg_excerpt_length',
            [
                'label'     => esc_html__( 'Excerpt Length', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 15,
                'min'       => 5,
                'max'       => 100,
                'condition' => [ 'hmcodpg_show_excerpt' => 'yes' ],
            ]
        );

        $this->add_control(
            'hmcodpg_show_meta',
            [
                'label'        => esc_html__( 'Show Meta', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmcodpg_show_read_more',
            [
                'label'        => esc_html__( 'Show Read More', 'hmcoders-elementor-addon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'hmcoders-elementor-addon' ),
                'label_off'    => esc_html__( 'Hide', 'hmcoders-elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'hmcodpg_read_more_text',
            [
                'label'     => esc_html__( 'Read More Text', 'hmcoders-elementor-addon' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Read More', 'hmcoders-elementor-addon' ),
                'condition' => [ 'hmcodpg_show_read_more' => 'yes' ],
            ]
        );

        $this->end_controls_section();
    }

    private function hmcodpg_get_post_types() {
        $post_types = get_post_types( [ 'public' => true ], 'objects' );
        $options    = [];
        foreach ( $post_types as $post_type ) {
            $options[ $post_type->name ] = $post_type->label;
        }
        return $options;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $posts_per_page = absint( $settings['hmcodpg_posts_per_page'] );

        $args = [
            'post_type'           => sanitize_text_field( $settings['hmcodpg_post_type'] ),
            'posts_per_page'      => $posts_per_page,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ];

        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) : 
        $columns = isset($settings['hmcodpg_columns']) ? $settings['hmcodpg_columns'] : 3; 
        ?>
            <div class="hmcoders-post-grid" data-columns="<?php echo esc_attr($columns); ?>">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="hmcoders-post-card">
                        <?php if ( 'yes' === $settings['hmcodpg_show_image'] && has_post_thumbnail() ) : ?>
                            <div class="hmcoders-post-image">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="hmcoders-post-content">
                            <?php if ( 'yes' === $settings['hmcodpg_show_title'] ) : ?>
                                <h3 class="hmcoders-post-title">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>">
                                        <?php echo esc_html( get_the_title() ); ?>
                                    </a>
                                </h3>
                            <?php endif; ?>

                            <?php if ( 'yes' === $settings['hmcodpg_show_meta'] ) : ?>
                                <div class="hmcoders-post-meta">
                                    <span class="hmcoders-post-date"><?php echo esc_html( get_the_date() ); ?></span>
                                    <span class="hmcoders-post-author">
                                        <?php
                                        echo esc_html__( 'by', 'hmcoders-elementor-addon' ) . ' ' . esc_html( get_the_author() );
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php if ( 'yes' === $settings['hmcodpg_show_excerpt'] ) : ?>
                                <div class="hmcoders-post-excerpt">
                                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), absint( $settings['hmcodpg_excerpt_length'] ), '...' ) ); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ( 'yes' === $settings['hmcodpg_show_read_more'] ) : ?>
                                <div class="hmcoders-post-read-more">
                                    <a href="<?php echo esc_url( get_permalink() ); ?>" class="hmcoders-read-more-btn">
                                        <?php echo esc_html( $settings['hmcodpg_read_more_text'] ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif;

        wp_reset_postdata();
    }

    protected function content_template() {}
}
