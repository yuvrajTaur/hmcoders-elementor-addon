<?php

namespace hmcoders\Elementor_Addon;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Hmake_Timeline_Render {

    /**
     * Render Timeline HTML for Elementor widget or shortcode
     *
     * @param array $settings Elementor widget settings or shortcode attributes.
     * @return void
     */

public static function hmake_timeline_render_widget( $settings = [] ) {
    // Get data: shortcode or Elementor repeater
    $shortcode_data = method_exists(__CLASS__, 'hmake_timeline_shortcode') ? self::hmake_timeline_shortcode($settings) : [];
    $widget_data    = $settings['hmceak_timeline_items'] ?? [];

    // var_dump($shortcode_data[0]['hmceak_item_alignment']);die();

    // Decide which data to use
    $timeline_items = !empty($shortcode_data) ? $shortcode_data : $widget_data;

    if ( empty($timeline_items) ) {
        return; // Nothing to render
    }

    // Layout
    $layout    = $settings['hmceak_timeline_layout'] ?? ($shortcode_data[0]['hmceak_item_layout'] ?? 'vertical');
    $alignment = '';

    if ( $layout !== 'horizontal' ) {
        $alignment = $settings['hmceak_timeline_alignment'] ?? ($shortcode_data[0]['hmceak_item_alignment'] ?? 'left');
    }

    $animated = ( isset($settings['hmceak_show_animation']) && 'yes' === $settings['hmceak_show_animation'] );

    // Wrapper classes
    $timeline_class = 'hmcoders-timeline-' . $layout;
    if ( !empty($alignment) ) {
        $timeline_class .= ' hmcoders-timeline-' . $alignment;
    }
    if ( $animated ) {
        $timeline_class .= ' hmcoders-timeline-animated';
    }

    ob_start();
    ?>
    <div class="hmcoders-timeline-wrapper <?php echo esc_attr( $timeline_class ); ?>">
        <div class="hmcoders-timeline-line"></div>

        <?php if ( 'horizontal' === $layout ) : ?>
            <div class="hmcoders-timeline-items-container" id="hmcoders-timeline-container">
        <?php endif; ?>

        <?php foreach ( $timeline_items as $index => $item ) :
            // Determine alignment and classes
            if ( 'horizontal' === $layout ) {
                $item_class = 'hmcoders-timeline-item';
            } else {
                $item_alignment = $alignment;
                if ( 'center' === $alignment ) {
                    $item_alignment = ( $index % 2 === 0 ) ? 'left' : 'right';
                }
                $item_position = in_array( $item_alignment, ['left','right'], true ) ? $item_alignment : 'left';
                $item_class = 'hmcoders-timeline-item hmcoders-timeline-' . $item_position;
            }

            // Link wrapper logic
            $link_tag   = 'div';
            $link_attrs = '';
            $link_data  = $item['hmceak_item_link'] ?? [];
            if ( !empty($link_data['url']) ) {
                $link_tag = 'a';
                $attrs = ['href="' . esc_url($link_data['url']) . '"'];
                if ( !empty($link_data['is_external']) ) {
                    $attrs[] = 'target="_blank"';
                }
                if ( !empty($link_data['nofollow']) ) {
                    $attrs[] = 'rel="nofollow"';
                }
                $link_attrs = implode(' ', $attrs);
            }

            // Animation settings
            $aos_value = '';
            if ( $animated ) {
                if ( 'horizontal' === $layout ) {
                    $aos_value = 'fade-up';
                } else {
                    $aos_direction = ( isset($item_position) && $item_position === 'right' ) ? 'left' : 'right';
                    $aos_value = 'fade-' . $aos_direction;
                }
            }
            ?>
            <<?php echo esc_html($link_tag); ?>
                class="<?php echo esc_attr($item_class); ?>"
                <?php echo $link_attrs; ?>
                <?php if ( $aos_value ) : ?> data-aos="<?php echo esc_attr($aos_value); ?>"<?php endif; ?>>

                <?php if ( !empty($item['hmceak_item_date']) ) : ?>
                    <div class="hmcoders-timeline-date"><?php echo esc_html($item['hmceak_item_date']); ?></div>
                <?php endif; ?>

                <div class="hmcoders-timeline-marker">
                    <div class="hmcoders-timeline-icon">
                        <?php
                        if ( !empty($item['hmceak_item_icon']) ) {
                            \Elementor\Icons_Manager::render_icon( $item['hmceak_item_icon'], ['aria-hidden'=>'true'] );
                        }
                        ?>
                    </div>
                </div>

                <div class="hmcoders-timeline-content">
                    <?php if ( !empty($item['hmceak_item_image']['url']) ) : ?>
                        <div class="hmcoders-timeline-image">
                            <img src="<?php echo esc_url($item['hmceak_item_image']['url']); ?>" alt="<?php echo esc_attr($item['hmceak_item_title'] ?? ''); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if ( !empty($item['hmceak_item_title']) ) : ?>
                        <h3 class="hmcoders-timeline-title"><?php echo esc_html($item['hmceak_item_title']); ?></h3>
                    <?php endif; ?>

                    <?php if ( !empty($item['hmceak_item_description']) ) : ?>
                        <div class="hmcoders-timeline-description">
                            <p><?php echo wp_kses_post(wp_trim_words($item['hmceak_item_description'], 30)); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </<?php echo esc_html($link_tag); ?>>
        <?php endforeach; ?>

        <?php if ( 'horizontal' === $layout ) : ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
    


    /**
     * Shortcode function to fetch timeline items from CPT
     *
     * @param array $atts Shortcode attributes.
     * @return array Timeline items.
     */
    public static function hmake_timeline_shortcode( $atts = [] ) {
        // Parse shortcode attributes with defaults
        $atts = shortcode_atts([
            'count'     => 5,           
            'order'     => 'DESC',      
            'layout'    => 'vertical',  
            'alignment' => 'center',   
            'animated'  => 'yes',       
        ], $atts, 'hmake_timeline');

        // Build WP_Query arguments
        $query_args = [
            'post_type'      => 'hmake_timeline',
            'posts_per_page' => intval($atts['count']),
            'order'          => in_array(strtoupper($atts['order']), ['ASC','DESC'], true) ? strtoupper($atts['order']) : 'DESC',
            'orderby'        => 'date',
            'post_status'    => 'publish',
        ];

        $query = new \WP_Query($query_args);
        $items = [];

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();

                $items[] = [
                    'id'                     => get_the_ID(),
                    'hmceak_item_title'      => get_the_title(),
                    'hmceak_item_description'=> get_the_content(),
                    'hmceak_item_image'      => [
                        'url' => get_the_post_thumbnail_url( get_the_ID(), 'full' )
                    ],
                    'hmceak_item_date'       => get_the_date(),
                    'hmceak_item_link'       => [
                        'url' => get_permalink(),
                    ],
                    'hmceak_item_icon'       => '', // optional, you can extend to use a custom field
                    'hmceak_item_alignment'  => $atts['alignment'],
                    'hmceak_item_layout'     => $atts['layout'],
                    'hmceak_item_animated'   => $atts['animated'],
                ];
            }
        }

        wp_reset_postdata();
        return $items;
    }


    /**
     * Elementor widget settings: show CPT if available, otherwise use repeater fields
     *
     * @param array $settings Elementor widget settings.
     * @return array Timeline items for rendering
     */
    public static function hmake_timeline_elementor( $settings = [] ) {
        $cpt_items = self::hmake_timeline_shortcode([ 'count'=>-1 ]); // fetch all CPT items
        if ( !empty($cpt_items) ) {
            return $cpt_items;
        }
        return $settings['hmceak_timeline_items'] ?? [];
    }
}
