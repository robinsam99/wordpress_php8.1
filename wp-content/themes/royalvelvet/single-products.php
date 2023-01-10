<?php get_header(); ?>

<?php
    $id = get_the_ID();
    $colors = get_the_terms( get_the_ID(), 'color' );
    $patterns = get_the_terms( get_the_ID(), 'pattern' );
    $rooms = get_the_terms( get_the_ID(), 'room' );
    $set = get_the_terms( get_the_ID(), 'set' );
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ));
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="product">
        <div class="container">
            <div class="desk_product_image product_left" data-set="product_image">
              <div class="product_image">
                  <?php if(has_post_thumbnail()) : ?>
                      <?php the_post_thumbnail('product-card-list'); ?>
                  <?php endif; ?>
                  <?php if(get_field('additional_product_dialog')) : ?>
                      <p class="additional_products">Some additional products shown here are also available at JCPenney.com</p>
                  <?php endif; ?>
                  <div class="share">
                      <span>SHARE:</span>
                      <ul>
                          <li><a onClick="__gaTracker('send', 'event', 'Product Detail: Social Share', 'Click', 'Facebook Share')" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                          <li><a onClick="__gaTracker('send', 'event', 'Product Detail: Social Share', 'Click', 'Twitter Share')" href="https://twitter.com/intent/tweet?text=<?php echo urlencode('Royal Velvet '.get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                          <li><a onClick="__gaTracker('send', 'event', 'Product Detail: Social Share', 'Click', 'Pinterest Share')" data-pin-do="buttonPin" data-pin-round="true" data-pin-save="false" href="https://pinterest.com/pin/create/bookmarklet/?url=<?php echo $image[0]; ?>&description=<?php echo 'Royal Velvet '.get_the_title().' - '.get_permalink(); ?>" target="_blank"></a></li>
                      </ul>
                  </div>
              </div>
            </div>
            <div class="product_right">
                <h1><?php the_title(); ?></h1>
                <div class="content_wysiwyg">
                    <?php the_content(); ?>
                </div>
                <div class="tags">
                    <ul>
                        <?php foreach($colors as $color) : ?>
                            <li><a href="/?filter=<?php echo $color->slug; ?>"><?php echo $color->name; ?></a></li>
                        <?php endforeach; ?>
                        <?php foreach($patterns as $pattern) : ?>
                            <li><a href="/?filter=<?php echo $pattern->slug; ?>"><?php echo $pattern->name; ?></a></li>
                        <?php endforeach; ?>
                        <?php foreach($rooms as $room) : ?>
                            <li><a href="/?filter=<?php echo $room->slug; ?>"><?php echo $room->name; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="mobile_product_image product_left" data-set="product_image"></div>
                <div class="mobile_shop_jcp" data-set="shop_jcp"></div>
                <div class="related_products">
                    <ul>
                        <?php
                            $args = array(
                                'post_type' => 'products',
                                'posts_per_page' => 4,
                                'post__not_in' => array($id),
                                'tax_query' => array(
                            		array(
                            			'taxonomy' => 'set',
                            			'field'    => 'slug',
                            			'terms'    => $set[0]->slug
                            		),
                            	),
                            );

                            $products = new WP_Query($args);

                            while( $products->have_posts() ) : $products->the_post();
                        ?>

                            <li>
                                <a onClick="__gaTracker('send', 'event', 'Product Detail: Related Products', 'Click', '<?php the_title(); ?>')" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                                <a onClick="__gaTracker('send', 'event', 'Product Detail: Related Products', 'Click', '<?php the_title(); ?>')" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </li>

                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                </div>
                <?php if(get_field('shop_jcpenny_link')) : ?>
                    <div class="desk_shop_jcp" data-set="shop_jcp">
                        <div class="shop_jcp">
                            <a onClick="__gaTracker('send', 'event', 'Product Detail: JCPenney', 'Click', 'Shop@JCPenney')" href="<?php the_field('shop_jcpenny_link'); ?>" target="_blank">Shop JCPenney</a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php $stylemaker_secrets = get_field('stylemaker_secrets'); ?>
                <?php if($stylemaker_secrets) : ?>
                    <div class="side_border">
                        <h3>
                            <span>STYLEMAKER SECRETS</span>
                        </h3>
                    </div>
                    <div class="style_maker_secrets">
                        <ul>
                            <?php foreach($stylemaker_secrets as $id) : ?>
                                <li>
                                    <?php
                        				if (get_field('page_type', $id) === 'video') {
                        					$extra_label = '[Video] - ';
                        				} else {
                        					$extra_label = '';
                        				}
                        			?>
                                    <?php if(has_post_thumbnail($id)) : ?>
                    					<a onClick="__gaTracker('send', 'event', 'Product Detail: Stylemaker Secrets', 'Click', '<?php echo $extra_label . get_the_title($id); ?>')" href="<?php echo get_the_permalink($id); ?>"><?php echo get_the_post_thumbnail($id, 'stylemaker'); ?></a>
                    				<?php else : ?>
                    					<a onClick="__gaTracker('send', 'event', 'Product Detail: Stylemaker Secrets', 'Click', '<?php echo $extra_label . get_the_title($id); ?>')" href="<?php echo get_the_permalink($id); ?>"><img src="<?php echo bloginfo('template_url'); ?>/images/stylemaker_image.jpg" /></a>
                    				<?php endif; ?>
                    				<a onClick="__gaTracker('send', 'event', 'Product Detail: Stylemaker Secrets', 'Click', '<?php echo $extra_label . get_the_title($id); ?>')" href="<?php echo get_the_permalink($id); ?>">
                                        <p>Stylemaker Secret:</p>
                                        <?php echo get_the_title($id); ?> <?php if(get_field('page_type', $id) === 'video') { echo '(Video)'; } ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="back_to_home">
                    <a href="/">RETURN HOME</a>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; else: ?>

<?php endif; ?>

<?php get_footer(); ?>
