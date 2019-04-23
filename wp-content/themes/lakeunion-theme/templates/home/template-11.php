<!-- Carousel -->
<div id="boat-carousel" class="carousel slide hidden-xs" data-ride="carousel">
    <!-- Indicators -->
    <?php echo do_shortcode('[image-carousel category="Home" twbs="3"]'); ?>
</div>
<!-- Carousel END -->

<!-- Welcome / Brands -->
<div class="row">
    <div class="col-sm-8">
        <?php essentialelite_welcome_message(); ?>
    </div>
    <div class="col-sm-4 quick-search">
        <?php if (defined('OEM_SHOWROOMS_BASE_URL')) : $brands = Showrooms_Helper::get_home_brands(6); ?>
            <?php if (!empty($brands)) : ?>
                <h3>Authorized Dealer of These Fine Yachts and Boats</h3>
                <br />
                <!-- Thumbnails -->
                <?php foreach ($brands as $index => $brand) : ?>
                    <a href="<?php echo $brand['url'] ?>">
                        <?php echo $brand['logo']; ?>
                    </a>
                    <?php echo ($index < (sizeof($brands)-1)?"<hr />":""); ?>
                <?php endforeach; ?>
                <!-- Thumbnails END -->
            <?php endif; ?>
        <?php endif; ?>
        <br />
    </div>
</div>
<!-- Welcome / Brands END -->

</div> <!-- /container -->
<div class="featured-boats">
    <div class="container">

        <!-- Featured Boats -->
        <div class="row">
            <div class="col-md-12">
                <h2>Featured Boats</h2>

                <div class="row">

                    <?php

                    $args = array(
                        'post_type' => 'featured_boats',
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'ASC',
                        'posts_per_page' => 3
                    );

                    $the_query = new WP_Query($args); ?>

                    <?php if ($the_query->have_posts()) : ?>
                        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

                            <div class="col-sm-4">
                                <div class="thumbnail fboat">
                                    <a href="<?php echo get_post_meta($post->ID, 'Link', true) ?>">
                                        <?php $image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                                        <img src="<?php echo $image_src[0]; ?>" class="img-responsive">
                                    </a>

                                    <div class="caption text-center">
                                        <h4><?php echo get_post_meta($post->ID, 'Year', true) . " " . get_post_meta($post->ID, 'Make', true) . " " . get_post_meta($post->ID, 'Model', true); ?></h4>

                                        <p>
                                            Price:
                                            <strong><?php echo get_post_meta($post->ID, 'Price', true); ?></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                        <div class="col-sm-4">
                            <div class="thumbnail fboat">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/feature-image.jpg"
                                     class="img-responsive">

                                <div class="caption text-center">
                                    <h4>2009 Sea Ray 270 Sundancer</h4>

                                    <p>
                                        Price:
                                        <strong>1,000,000</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail fboat">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/feature-image.jpg"
                                     class="img-responsive">

                                <div class="caption text-center">
                                    <h4>2009 Sea Ray 270 Sundancer</h4>

                                    <p>
                                        Price:
                                        <strong>1,000,000</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="thumbnail fboat">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/feature-image.jpg"
                                     class="img-responsive">

                                <div class="caption text-center">
                                    <h4>2009 Sea Ray 270 Sundancer</h4>

                                    <p>
                                        Price:
                                        <strong>1,000,000</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Featured Boats END -->
    </div>
    <!-- /container -->
</div>
<div class="container">