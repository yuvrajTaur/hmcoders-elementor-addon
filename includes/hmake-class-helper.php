<?php
if (!defined('ABSPATH')) exit;

class Hmake_Helper {

    /**
     * Return a list of icons (example method)
     *
     * @return array Icon class => Icon name
     */
    public static function hmake_get_icon_list() {
        return [
            'fa fa-adjust'       => 'Adjust',
            'fa fa-anchor'       => 'Anchor',
            'fa fa-archive'      => 'Archive',
            'fa fa-area-chart'   => 'Area Chart',
            'fa fa-arrows'       => 'Arrows',
            'fa fa-arrows-h'     => 'Arrows Horizontal',
            'fa fa-arrows-v'     => 'Arrows Vertical',
            'fa fa-asterisk'     => 'Asterisk',
            'fa fa-at'           => 'At',
            'fa fa-automobile'   => 'Automobile',
            // Add more icons as needed
        ];
    }

    /**
     * Render Timeline Widget Output
     *
     * Query Timeline CPT items and generate HTML output.
     * Usable both with Elementor and shortcode.
     *
     * @param array $atts Shortcode or widget attributes ['count' => int, 'order' => 'ASC'|'DESC']
     * @return string Rendered HTML content
     */
    public static function hmake_render_timeline($atts = []) {
        // Default attributes and sanitize inputs
        $atts = shortcode_atts([
            'count' => 5,
            'order' => 'DESC',
        ], $atts, 'hmake_timeline');

        $query_args = [
            'post_type'      => 'hmceak_timeline',
            'posts_per_page' => intval($atts['count']),
            'order'          => in_array(strtoupper($atts['order']), ['ASC', 'DESC']) ? strtoupper($atts['order']) : 'DESC',
            'orderby'        => 'date',
        ];

        $query = new WP_Query($query_args);

        // Start output buffering to capture HTML output
        ob_start();

        if ($query->have_posts()) {
            echo '<div class="hmake-timeline-wrapper">';
            while ($query->have_posts()) {
                $query->the_post();

                $date = get_the_date();
                $title = get_the_title();
                $content = get_the_content();
                $thumbnail = has_post_thumbnail() ? get_the_post_thumbnail(null, 'medium', ['class' => 'timeline-thumbnail']) : '';

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('hmake-timeline-item'); ?>>
                    <div class="timeline-thumbnail-wrapper"><?php echo $thumbnail; ?></div>
                    <div class="timeline-content">
                        <time class="timeline-date"><?php echo esc_html($date); ?></time>
                        <h3 class="timeline-title"><?php echo esc_html($title); ?></h3>
                        <div class="timeline-description"><?php echo wp_kses_post(wpautop($content)); ?></div>
                    </div>
                </article>
                <?php
            }
            echo '</div>';
        } else {
            echo '<p>' . esc_html__('No timeline entries found.', 'hmcoders') . '</p>';
        }

        // Reset postdata after loop
        wp_reset_postdata();

        // Return buffered content
        return ob_get_clean();
    }
}
// function hmcoders_get_template( $template_name, $args = [] ) {
//     // Define base template path
//     $base_path = plugin_dir_path( __FILE__ ) . '../templates/';

//     // Sanitize template name and build full path
//     $template_file = $base_path . $template_name . '.php';

//     if ( file_exists( $template_file ) ) {
//         // Extract args to variables for templates use
//         if ( is_array( $args ) ) {
//             extract( $args );
//         }
//         include $template_file;
//     }
// }
