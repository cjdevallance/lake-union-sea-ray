<?php

/*

    Template Name: Promotions

*/

get_header( 'sub' ); ?>

<div class="container">
  <div class="col-lg-12"><h1><?php the_title(); ?></h1></div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">

        <div id="promo-slider">

            <ul class="bxslider">

                <?php

                $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

                $custom_args = array(
                    'post_type' => 'post',
                    'category_name' => 'promotions',
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
                'category_name' => 'promotions',
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

        <?php

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $custom_args = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'category_name' => 'promotions',
            'paged' => $paged
        );

        $custom_query = new WP_Query( $custom_args ); ?>

        <?php  while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

                <?php if(get_field('hero_slider')): ?>

                    <?php while(has_sub_field('hero_slider')): ?>

                        <article class="single-post">

                            <span class="feat-post-img">

                                <a href=" <?php the_permalink(); ?> "><img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" /></a>

                            </span>

                            <div class="post-content-inner">

                                <a href=" <?php the_permalink(); ?> "><h1 class="boat-title"><?php the_field( 'boat_promo_name' ); ?> &bull;</h1> <h1 class="boat-title"><?php the_title(); ?></h1></a>

                                    <div class="clearfix"></div>

                                <div class="post-inner"><?php the_excerpt(); ?></div>

                                <a href=" <?php the_permalink(); ?> " class="post-more-btn">MORE INFO</a>

                            </div>

                            <div class="clearfix"></div>

                        </article>

                    <?php break; endwhile; ?>

                <?php endif; ?>

            <?php endwhile; ?>

            <?php

            if (function_exists(custom_pagination)) {

                custom_pagination($custom_query->max_num_pages,"",$paged);

            }

            ?>



        <?php wp_reset_postdata(); ?>

    </section>

    </div>

<?php get_sidebar() ?>

</div>


<?php get_footer(); ?>
