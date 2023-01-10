<?php
/**
 * Template Name: Style Selector
 *
 */

get_header(); ?>

<div class="homepage">
    

    <div class="filter_section">
        <div class="container710">
            <?php the_field('text_area_under_slider'); ?>
            <ul class="top_level_filters">
                <li><a onClick="__gaTracker('send', 'event', 'Style Selector Bar', 'Click', 'All')" class="selected" href="#" data-filter="*">All</a></li>
                <li onClick="__gaTracker('send', 'event', 'Style Selector Bar', 'Click', 'Color')" class="neutral cool warm multi"><a href="#" data-filter="color_options">Color</a></li>
                <li onClick="__gaTracker('send', 'event', 'Style Selector Bar', 'Click', 'Pattern')" class="solid geometric decorative"><a href="#" data-filter="pattern_options">Pattern</a></li>
                <li onClick="__gaTracker('send', 'event', 'Style Selector Bar', 'Click', 'Room')" class="bedroom bathroom windows other"><a href="#" data-filter="room_options">Room</a></li>
            </ul>

            <div class="filter_hidden color_options">
                <ul>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Color', 'Click', 'Neutral')" class="neutral" data-category="neutral">
                        <div class="filter_title">Neutral</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/neutral_color_swatches.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Color', 'Click', 'Warm')" class="warm" data-category="warm">
                        <div class="filter_title">Warm</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/warm_color_swatches.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Color', 'Click', 'Cool')" class="cool" data-category="cool">
                        <div class="filter_title">Cool</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/cool_color_swatches.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Color', 'Click', 'Multi')" class="multi" data-category="multi">
                        <div class="filter_title">Multi</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/multi_color_swatches.jpg" /></div>
                    </li>
                </ul>
            </div>

            <div class="filter_hidden pattern_options">
                <ul>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Pattern', 'Click', 'Solid')" class="solid" data-category="solid">
                        <div class="filter_title">Solid</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/solid_pattern.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Pattern', 'Click', 'Geometric')" class="geometric" data-category="geometric">
                        <div class="filter_title">Geometric</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/geometric_pattern.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Pattern', 'Click', 'Decorative')" class="decorative" data-category="decorative">
                        <div class="filter_title">Decorative</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/decorative_pattern.jpg" /></div>
                    </li>
                </ul>
            </div>

            <div class="filter_hidden room_options">
                <ul>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Room', 'Click', 'Bedroom')" class="bedroom" data-category="bedroom">
                        <div class="filter_title">Bedroom</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/bedroom.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Room', 'Click', 'Bathroom')" class="bathroom" data-category="bathroom">
                        <div class="filter_title">Bathroom</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/bathroom.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Room', 'Click', 'Windows')" class="windows" data-category="windows">
                        <div class="filter_title">Windows</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/windows.jpg" /></div>
                    </li>
                    <li onClick="__gaTracker('send', 'event', 'Style Selector Bar: Room', 'Click', 'Other')" class="other" data-category="other">
                        <div class="filter_title">Other</div>
                        <div class="filter_image"><img src="<?php echo bloginfo('template_url'); ?>/images/other.jpg" /></div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="mb_filters">
        <div class="container">
            <div class="media_boxes_container">
                <div class="layout_switch">
                    <p>View</p>
                    <ul>
                        <li onClick="__gaTracker('send', 'event', '', 'Click', 'View Change: Cascaded')" class="grid active"></li>
                        <li onClick="__gaTracker('send', 'event', '', 'Click', 'View Change: Stacked')" class="list"></li>
                    </ul>
                </div>

                <div id="grid">

                    <?php $product_order = get_field('product_order'); ?>

                    <?php $args = array(
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
                            <a data-title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url('product-card'); ?>" /></a>

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

                    <?php endwhile; wp_reset_postdata(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
