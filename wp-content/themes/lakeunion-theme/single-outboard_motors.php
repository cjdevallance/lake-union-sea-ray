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
                            <?php if(get_field('hours')) { echo '<li><strong>Hours:</strong> ' . get_field('hours') . '</li>'; } ?>
                          </ul>
                          </br>
                          <h2 class="orng-hl">Specifications</h2>
                        <ul class="specifications">
                            <?php if(get_field('hp/kw_prop')) { echo '<li><strong>HP/Kw @ Prop:</strong> ' . get_field('hp/kw_prop') . '</li>'; } ?>
                            <?php if(get_field('displacement')) { echo '<li><strong>Displacement (CID/cc):</strong> ' . get_field('displacement') . '</li>'; } ?>
                            <?php if(get_field('cooling_system')) { echo '<li><strong>Axle Style:</strong> ' . get_field('axle_style') . '</li>'; } ?>
                            <?php if(get_field('cylinder_configuration')) { echo '<li><strong>Tire Size:</strong> ' . get_field('tire_size') . '</li>'; } ?>
                            <?php if(get_field('bore_stroke')) { echo '<li><strong>Width Between Fenders:</strong> ' . get_field('width_between_fenders') . '</li>'; } ?>
                            <?php if(get_field('ignition')) { echo '<li><strong>Overall Width:</strong> ' . get_field('overall_width') . '</li>'; } ?>
                            <?php if(get_field('starting')) { echo '<li><strong>Overall Length:</strong> ' . get_field('overall_length') . '</li>'; } ?>
                            <?php if(get_field('fuel_system')) { echo '<li><strong>Fuel System:</strong> ' . get_field('fuel_system') . '</li>'; } ?>
                            <?php if(get_field('fuel_induction_system')) { echo '<li><strong>Fuel Induction System:</strong> ' . get_field('fuel_induction_system') . '</li>'; } ?>
                            <?php if(get_field('trim_positions')) { echo '<li><strong>Trim Positions:</strong> ' . get_field('trim_positions') . '</li>'; } ?>
                            <?php if(get_field('alternator_amp')) { echo '<li><strong>Alternator Amp:</strong> ' . get_field('alternator_amp') . '</li>'; } ?>
                            <?php if(get_field('gear_shift')) { echo '<li><strong>Gear Shift:</strong> ' . get_field('gear_shift') . '</li>'; } ?>
                            <?php if(get_field('steering')) { echo '<li><strong>Steering:</strong> ' . get_field('steering') . '</li>'; } ?>
                            <?php if(get_field('_shallow_water_drive')) { echo '<li><strong>Shallow Water Drive:</strong> ' . get_field('_shallow_water_drive') . '</li>'; } ?>
                            <?php if(get_field('shaft_length')) { echo '<li><strong>Shaft Length:</strong> ' . get_field('shaft_length') . '</li>'; } ?>
                            <?php if(get_field('full-throttle_rpm_range')) { echo '<li><strong>Full-throttle RPM Range:</strong> ' . get_field('full-throttle_rpm_range') . '</li>'; } ?>
                            <?php if(get_field('recommended_oil')) { echo '<li><strong>Recommended Oil:</strong> ' . get_field('recommended_oil') . '</li>'; } ?>
                            <?php if(get_field('carb_star_rating')) { echo '<li><strong>Carb Star Rating:</strong> ' . get_field('carb_star_rating') . '</li>'; } ?>
                            <?php if(get_field('remote_fuel_tank')) { echo '<li><strong>Remote Fuel Tank:</strong> ' . get_field('remote_fuel_tank') . '</li>'; } ?>
                            <?php if(get_field('exhaust_system')) { echo '<li><strong>Exhaust System:</strong> ' . get_field('exhaust_system') . '</li>'; } ?>
                            <?php if(get_field('recommended_fuel')) { echo '<li><strong>Recommended Fuel:</strong> ' . get_field('Recommended Fuel') . '</li>'; } ?>
                            <?php if(get_field('gearcase_ratio')) { echo '<li><strong>Gearcase Ratio:</strong> ' . get_field('gearcase_ratio') . '</li>'; } ?>
                            <?php if(get_field('dry_weight')) { echo '<li><strong>Dry Weight:</strong> ' . get_field('dry_weight') . '</li>'; } ?>
                            <?php if(get_field('shallow_water_trim_range')) { echo '<li><strong>Shipping Weight:</strong> ' . get_field('shipping_weight') . '</li>'; } ?>
                            <?php if(get_field('integral_fuel_tank')) { echo '<li><strong>Integral Fuel Tank:</strong> ' . get_field('integral_fuel_tank') . '</li>'; } ?>
                            <?php if(get_field('optional_fuel_tank')) { echo '<li><strong>Optional Fuel Tank:</strong> ' . get_field('optional_fuel_tank') . '</li>'; } ?>
                            <?php if(get_field('engine_protection_operator_warning_system')) { echo '<li><strong>Engine Protection Operator Warning System:</strong> ' . get_field('engine_protection_operator_warning_system') . '</li>'; } ?>
                            <?php if(get_field('recommended_fuel')) { echo '<li><strong>Recommended Fuel:</strong> ' . get_field('recommended_fuel') . '</li>'; } ?>
                                </br>
                            <?php if(get_field('standard_features')) { echo '<li><strong>Standard Features:</strong><p> ' . get_field('standard_features') . '</p></li>'; } ?>

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
