<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( empty( $settings['hmceak_timeline_items'] ) || ! is_array( $settings['hmceak_timeline_items'] ) ) {
    return;
}

$layout    = $settings['hmceak_timeline_layout'] ?? 'vertical';
$alignment = $settings['hmceak_timeline_alignment'] ?? 'left';
$animated  = ( isset( $settings['hmceak_show_animation'] ) && 'yes' === $settings['hmceak_show_animation'] );
$timeline_class  = 'hmcoders-timeline-' . $layout;
$timeline_class .= ' hmcoders-timeline-' . $alignment;
if ( $animated ) {
    $timeline_class .= ' hmcoders-timeline-animated';
}
?>
<div class="hmcoders-timeline-wrapper <?php echo esc_attr( $timeline_class ); ?>">
    <div class="hmcoders-timeline-line"></div>

    <?php if ( 'horizontal' === $layout ) : ?>
        <div class="hmcoders-timeline-items-container">
    <?php endif; ?>

    <?php foreach ( $settings['hmceak_timeline_items'] as $index => $item ) :
        if ( 'horizontal' === $layout ) {
            $item_class = 'hmcoders-timeline-item';
        } else {
            $item_alignment = $alignment;
            if ( 'center' === $alignment ) {
                $item_alignment = ( (int) $index % 2 === 0 ) ? 'left' : 'right';
            }
            $item_position = in_array( $item_alignment, [ 'left', 'right' ], true ) ? $item_alignment : 'left';
            $item_class = 'hmcoders-timeline-item hmcoders-timeline-' . $item_position;
        }

        $link_tag = 'div';
        $link_attrs = '';
        if ( ! empty( $item['hmceak_item_link']['url'] ) ) {
            $link_tag = 'a';
            $attrs = [ 'href="' . esc_url( $item['hmceak_item_link']['url'] ) . '"' ];
            if ( ! empty( $item['hmceak_item_link']['is_external'] ) ) {
                $attrs[] = 'target="_blank"';
            }
            if ( ! empty( $item['hmceak_item_link']['nofollow'] ) ) {
                $attrs[] = 'rel="nofollow"';
            }
            $link_attrs = implode( ' ', $attrs );
        }

        if ( 'horizontal' === $layout ) {
            $aos_value = 'fade-up';
        } else {
            $aos_direction = ( $item_position === 'right' ) ? 'left' : 'right';
            $aos_value = 'fade-' . $aos_direction;
        }
    ?>
        <div class="<?php echo esc_attr( $item_class ); ?>" data-aos="<?php echo esc_attr( $aos_value ); ?>">
            <?php if ( ! empty( $item['hmceak_item_date'] ) ) : ?>
                <div class="hmcoders-timeline-date"><?php echo esc_html( $item['hmceak_item_date'] ); ?></div>
            <?php endif; ?>

            <div class="hmcoders-timeline-marker">
                <div class="hmcoders-timeline-icon">
                    <?php
                    if ( ! empty( $item['hmceak_item_icon'] ) ) {
                        \Elementor\Icons_Manager::render_icon( $item['hmceak_item_icon'], [ 'aria-hidden' => 'true' ] );
                    }
                    ?>
                </div>
            </div>

            <<?php echo esc_attr( $link_tag ); ?> class="hmcoders-timeline-content" <?php echo wp_kses_post( $link_attrs ); ?>>
                <?php if ( ! empty( $item['hmceak_item_image']['url'] ) ) : ?>
                    <div class="hmcoders-timeline-image">
                        <img src="<?php echo esc_url( $item['hmceak_item_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['hmceak_item_title'] ?? '' ); ?>">
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $item['hmceak_item_title'] ) ) : ?>
                    <h3 class="hmcoders-timeline-title"><?php echo esc_html( $item['hmceak_item_title'] ); ?></h3>
                <?php endif; ?>

                <?php if ( ! empty( $item['hmceak_item_description'] ) ) : ?>
                    <div class="hmcoders-timeline-description">
                        <p><?php echo wp_kses_post( $item['hmceak_item_description'] ); ?></p>
                    </div>
                <?php endif; ?>
            </<?php echo esc_attr( $link_tag ); ?>>
        </div>
    <?php endforeach; ?>

    <?php if ( 'horizontal' === $layout ) : ?>
        </div>
    <?php endif; ?>
</div>
