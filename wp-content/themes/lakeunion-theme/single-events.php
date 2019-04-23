<?php

/*

    Template Name: Single events

*/

get_header( 'sub' ); ?>
<div class="container">
test
  <div class="col-lg-12"><h1><?php the_title(); ?></h1></div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
        
        <div id="promo-slider">

            <ul class="bxslider">

                <?php

                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                $custom_args = array(
                    'post_type' => 'post',
                    'category_name' => 'events',
                );

                $custom_query = new WP_Query( $custom_args ); ?>

                <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                    <?php if(get_field('hero_slider')): ?>

                        <?php while(has_sub_field('hero_slider')): ?>

                            <li>

                                <img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" />

                            </li>

                        <?php break; endwhile; ?>

                    <?php endif; ?>

                <?php endwhile; ?>

            </ul>

        <div class="clearfix"></div>

        <div id="bx-pager" class="hidden-xs hidden-sm">

            <?php $int = 0; ?>

            <?php

            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

            $custom_args = array(
                'post_type' => 'post',
                'category_name' => 'events',
            );

            $custom_query = new WP_Query( $custom_args ); ?>

                    <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                        <?php if(get_field('hero_slider')): ?>

                        <?php while(has_sub_field('hero_slider')): ?>

                        <a data-slide-index="<?php echo $int++; ?>" href="">

                            <img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" />

                        </a>

                    <?php break; endwhile; ?>

                <?php endif; ?>

            <?php endwhile; ?>

        </div>

        </div>
    
    <section id="promo-posts">
    
    <h2>Current Promotions</h2>


<!-- Main Events Content -->

<?php tribe_get_template_part( 'day/content' ) ?>

<div class="clearfix"></div>

        <div id="cal">

            <h1>Calender Goes Here</h1>

       <?php tribe_get_template_part( 'month/content' ) ?>

        </div>

    </section>
    
    </div>
    
<?php get_sidebar() ?>
    
</div>


<?php get_footer(); ?>



