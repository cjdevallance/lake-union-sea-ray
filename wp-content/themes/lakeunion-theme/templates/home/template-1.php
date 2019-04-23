
<!-- Carousel -->
<div id="boat-carousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <?php echo do_shortcode('[image-carousel category="Home" twbs="3"]'); ?>
</div>
<!-- Carousel END -->
<?php if (defined('OEM_SHOWROOMS_BASE_URL')) : $brands = Showrooms_Helper::get_home_brands(); ?>
<?php if (!empty($brands)) : ?>
<!-- Thumbnails -->
</div>
<div class="row showroom-brands">
    <div class="container">
        <?php foreach ($brands as $brand) : ?>
            <div
                class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-<?php echo $brand['column_size'] ?>">
                <a href="<?php echo $brand['url'] ?>" class="thumbnail brand-logo">
                    <?php echo $brand['logo']; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="container">
    <!-- Thumbnails END -->
    <?php else: ?>
        <br/>
    <?php endif; ?>
    <?php else: ?>
        <br/>
    <?php endif; ?>

    <!-- Welcome / Contact Form -->
    <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12 welcome-message">
            <div class="jumbotron">
                <?php
                    essentialelite_welcome_message();
                ?>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 quick-search">
            <div class="jumbotron">
                <?php get_template_part('home', 'quick-search'); ?>
            </div>
        </div>
    </div>
    <!-- Welcome / Contact Form END -->

    <!--
        Wireframes dictate that feature boats have a page wide background colour
        and therefore, we treat it as such by closing the opened container
    -->
</div> <!-- /container -->
<div class="featured-boats">
    <div class="container">

        <!-- Featured Boats -->
        <div class="row">
            <div class="col-md-12">
                <h3>Featured Boats</h3>

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

                            <a href="<?php echo get_post_meta($post->ID, 'Link', true) ?>">
                                <div class="col-sm-4 fboat">
                                    <div class="fboat-single">

                                        <div class="fboat-title">

                                            <h5><?php echo get_post_meta($post->ID, 'Year', true) . " " . get_post_meta($post->ID, 'Make', true) . " <span>" . get_post_meta($post->ID, 'Model', true); ?></span></h5>

                                        </div>

                                        <div class="fboat-image">
                                            <?php $image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                                            <img src="<?php echo $image_src[0]; ?>" class="img-responsive">
                                        </div>

                                        <div class="caption text-center">
                                            <p>
                                                Price:
                                                <strong><?php echo get_post_meta($post->ID, 'Price', true); ?></strong>
                                            </p>
                                            <p>
                                                Location:
                                                <strong><?php echo get_post_meta($post->ID, 'Location', true); ?></strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                    <?php else : ?>
                        <div class="col-sm-4 fboat">
                            <div class="thumbnail">
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
                        <div class="col-sm-4 fboat">
                            <div class="thumbnail">
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
                        <div class="col-sm-4 fboat">
                            <div class="thumbnail">
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
