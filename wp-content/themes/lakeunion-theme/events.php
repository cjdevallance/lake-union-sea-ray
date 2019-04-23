<?php

/*

    Template Name: events

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

      <div id="tribe-events-content" class="tribe-events-single vevent hentry">

        <?php while ( have_posts() ) :  the_post(); ?>

          <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- Event featured image, but exclude link -->
            <?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

              <!-- Event content -->
              <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>

              <div class="tribe-events-single-event-description tribe-events-content entry-content description">

            <?php the_content(); ?>

          </div>

          <!-- Event meta -->

        <?php endwhile; ?>

        <!-- Event footer -->

      

        <!-- #tribe-events-footer -->

        </div><!-- #tribe-events-content -->

      </div>

    </section>

    </div>

  <?php get_sidebar() ?>

</div>

<?php get_footer(); ?>
