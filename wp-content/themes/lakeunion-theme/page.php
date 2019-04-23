

<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package LakeUnionSeaRay
 */


get_header(); ?>

<div class="container">

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

        <h2>Posts</h2>

        <?php

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $custom_args = array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'category_name' => 'promotions',
            'paged' => $paged
        );

        $custom_query = new WP_Query( $custom_args ); ?>

        <?php if ( $custom_query->have_posts() ) : ?>

            <!-- the loop -->
            <?php while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
                <article class="loop">
                    <h3><?php the_title(); ?></h3>
                    <div class="content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
            <!-- end of the loop -->

            <!-- pagination here -->
            <?php
            if (function_exists(custom_pagination)) {
                custom_pagination($custom_query->max_num_pages,"",$paged);
            }
            ?>

            <?php wp_reset_postdata(); ?>

        <?php else:  ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>

        </div>

        <?php get_sidebar(); ?>

    </div><!-- #main -->

</div><!-- #primary -->

<?php get_footer(); ?>
