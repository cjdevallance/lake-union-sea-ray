<?php
/**
 * The template for displaying all single posts.
 *
 * @package LakeUnionSeaRay
 */

get_header('sub'); ?>

<div class="container">
    <div class="col-lg-12"></div>

    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
    <div class="spacer" style="height:5px;"></div>

        <section id="promo-posts">

        <div class="single-post-slider">

            <ul class="bxslider">

                <?php if(get_field('hero_slider')): ?>

                    <?php while(has_sub_field('hero_slider')): ?>

                    <li>

                        <img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" />

                    </li>


                    <?php endwhile; ?>

                <?php endif; ?>

            </ul>

        </div>
            <div class="clearfix"></div>

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

                <article class="single-post">

                    <div class="post-content-single">

                        <h1><?php the_title(); ?></h1>

                            <div class="clearfix"></div>

                        <div class="post-inner"><?php the_content(); ?>
                          <p><?php the_content(); ?></p>
                          <h2 class="orng-hl">Details</h2>
                          <ul class="general-info">
                            <?php if(get_field('msrp')) { echo '<li><strong>MSRP:</strong> $' . get_field('msrp') . '</li>'; } ?>
                            <?php if(get_field('stock_number')) { echo '<li><strong>Stock Number:</strong> ' . get_field('stock_number') . '</li>'; } ?>
                            <?php if(get_field('status')) { echo '<li><strong>Status:</strong> ' . get_field('status') . '</li>'; } ?>
                            <?php if(get_field('actual_location')) { echo '<li><strong>Actual Location:</strong> ' . get_field('actual_location') . '</li>'; } ?>
                            <?php if(get_field('type')) { echo '<li><strong>Type:</strong> ' . get_field('type') . '</li>'; } ?>
                            <?php if(get_field('year')) { echo '<li><strong>Year:</strong> ' . get_field('year') . '</li>'; } ?>
                            <?php if(get_field('make')) { echo '<li><strong>Make:</strong> ' . get_field('make') . '</li>'; } ?>
                            <?php if(get_field('model_name')) { echo '<li><strong>Model:</strong> ' . get_field('model_name') . '</li>'; } ?>
                          </ul>
                          </br>
                          <h2 class="orng-hl">Specifications</h2>
                        <ul class="specifications">
                            <?php if(get_field('weight_capacity')) { echo '<li><strong>Weight Capacity:</strong> ' . get_field('weight_capacity') . '</li>'; } ?>
                            <?php if(get_field('number_of_bunks')) { echo '<li><strong>Number of Bunks:</strong> ' . get_field('number_of_bunks') . '</li>'; } ?>
                            <?php if(get_field('axle_style')) { echo '<li><strong>Axle Style:</strong> ' . get_field('axle_style') . '</li>'; } ?>
                            <?php if(get_field('tire_size')) { echo '<li><strong>Tire Size:</strong> ' . get_field('tire_size') . '</li>'; } ?>
                            <?php if(get_field('width_between_fenders')) { echo '<li><strong>Width Between Fenders:</strong> ' . get_field('width_between_fenders') . '</li>'; } ?>
                            <?php if(get_field('overall_width')) { echo '<li><strong>Overall Width:</strong> ' . get_field('overall_width') . '</li>'; } ?>
                            <?php if(get_field('overall_length')) { echo '<li><strong>Overall Length:</strong> ' . get_field('overall_length') . '</li>'; } ?>
                            <?php if(get_field('shipping_weight')) { echo '<li><strong>Shipping Weight:</strong> ' . get_field('shipping_weight') . '</li>'; } ?>
                          </ul>
                        </div>

                        
                       

                    </div>

                </article>

            <?php endwhile; ?>

        <?php endif; ?>

        </section>

    </div>

    <?php get_sidebar(); ?>
</div>



<?php if ( wp_is_mobile() ) { get_footer( 'mobile'); } else { get_footer(); } ?>
