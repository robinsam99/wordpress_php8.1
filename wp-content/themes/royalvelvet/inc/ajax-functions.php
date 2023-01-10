<?php
    function media_box_switch_layout() {

        $layout = isset( $_GET['layout'] ) ? $_GET['layout'] : null;
        $front_page = get_option('page_on_front');

        ob_start();

        $product_order = get_field('product_order', $front_page);

        $args = array(
            'post_type' => 'products',
            'posts_per_page' => -1,
            'order' => 'ASC'
        );

        if($product_order === 'set_order') {
            $args['meta_key'] = 'product_order';
            $args['orderby'] = 'meta_value_num';
        } else {
            $args['orderby'] = 'rand';
        }

        $products = new WP_Query($args);

        while( $products->have_posts() ) : $products->the_post();

            $colors = get_the_terms( get_the_ID(), 'color' );
            $patterns = get_the_terms( get_the_ID(), 'pattern' );
            $rooms = get_the_terms( get_the_ID(), 'room' );
        ?>

        <div class="media-box <?php foreach($colors as $color) { echo $color->slug . ' '; } foreach($patterns as $pattern) { echo $pattern->slug . ' '; } foreach($rooms as $room) { echo $room->slug . ' '; }?>">
            <?php if($layout === 'grid') : ?>
                <a data-title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url( 'product-card' ); ?>" /></a>
            <?php else : ?>
                <a data-title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url( 'product-card-list' ); ?>" /></a>
            <?php endif; ?>

            <div class="media-box-content">
                <div class="media-box-title"><a data-title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                <div class="tags">
                    <ul>
                        <?php foreach($colors as $color) : ?>
                            <li class="<?php echo $color->slug; ?>" data-filter="<?php echo $color->slug; ?>"><?php echo $color->name; ?></li>
                        <?php endforeach; ?>
                        <?php foreach($patterns as $pattern) : ?>
                            <li class="<?php echo $pattern->slug; ?>" data-filter="<?php echo $pattern->slug; ?>"><?php echo $pattern->name; ?></li>
                        <?php endforeach; ?>
                        <?php foreach($rooms as $room) : ?>
                            <li class="<?php echo $room->slug; ?>" data-filter="<?php echo $room->slug; ?>"><?php echo $room->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <?php
            endwhile; wp_reset_postdata();
            echo ob_get_clean();
            die();
    }

    add_action( 'wp_ajax_media_box_switch_layout', 'media_box_switch_layout' );
    add_action( 'wp_ajax_nopriv_media_box_switch_layout', 'media_box_switch_layout' );
