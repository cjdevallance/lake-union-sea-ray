<?php

/*

    Template Name: Blogs

*/

get_header( 'blog' ); ?>


    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">

    <section id="promo-posts">

        <?php

        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $custom_args = array(
            'post_type' => 'blog',
            'category_name' => 'blog, reviews, news-blog, destinations, fishermans-cove, recipes, diy',
            'posts_per_page' => 10,
            'paged' => $paged
        );

        $custom_query = new WP_Query( $custom_args );  //Check the WP_Query docs to see how you can limit which posts to display ?>

              <?php if ( $custom_query->have_posts() ) : ?>



                <div id="isotope-list">

                  <?php while ( $custom_query->have_posts() ) :$custom_query->the_post();

                    $termsArray = get_the_terms( $post->ID, "category" );  //Get the terms for this particular item

                    $termsString = ""; //initialize the string that will contain the terms

                    foreach ( $termsArray as $term ) { // for each term

                      $termsString .= $term->slug.' '; //create a string that has all the slugs

                    }

                  ?>

                  <?php if(get_field('hero_slider')): ?>

                      <?php while(has_sub_field('hero_slider')): ?>

                <div class="<?php echo $termsString; ?> item single-post"> <?php // 'item' is used as an identifier (see Setp 5, line 6) ?>

                  <span class="feat-post-img">

                      <a href=" <?php the_permalink(); ?> "><img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" /></a>

                  </span>

                  <div class="post-content-inner">

                      <a href=" <?php the_permalink(); ?> "><h1 class="boat-title"><?php the_title(); ?></h1> </a>

                          <div class="clearfix"></div>
                          <div class="post-cat-list"><?php echo get_the_category_list(); ?></div>
                          <div class="clearfix"></div>
                      <div class="post-inner"><?php the_excerpt(); ?></div>

                      <a href=" <?php the_permalink(); ?> " class="post-more-btn">MORE INFO</a>

                  </div>

                  <div class="clearfix"></div>


              </div> <!-- end item single-post -->


                                  <?php break; endwhile; ?>

                              <?php endif; ?>

                <?php endwhile;  ?>

                </div> <!-- end isotope-list -->


<?php endif; ?>

            <?php

            if (function_exists(custom_pagination)) {

                custom_pagination($custom_query->max_num_pages,"",$paged);

            }

            ?>



        <?php wp_reset_postdata(); ?>

    </section>

    </div>

<?php get_sidebar('blog') ?>

</div>
</div>

<?php get_footer(); ?>
