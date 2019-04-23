<?php
/**
 * The template for displaying all single posts.
 *
 * @package LakeUnionSeaRay
 */

get_header('sub'); ?>

<div class="container">
    <div class="col-lg-12"><h1><?php the_title(); ?></h1></div>

    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

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

                        <div class="post-inner"><?php the_content(); ?></div>

                    </div>

                </article>

            <?php endwhile; ?>

        <?php endif; ?>

        </section>

    </div>

    <?php get_sidebar(); ?>
</div>



<?php if ( wp_is_mobile() ) { get_footer( 'mobile'); } else { get_footer(); } ?>
