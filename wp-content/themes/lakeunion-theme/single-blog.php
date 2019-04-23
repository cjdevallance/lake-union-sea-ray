<?php
get_header('blog'); ?>

<div class="container_">
    <div class="col-lg-12 single-post-header">

      <h1><?php the_title(); ?></h1>
      <?php the_time('l, F jS, Y') ?>
      <div class="post-cat-list"><?php echo get_the_category_list(); ?></div>

    </div>

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

                            <div class="clearfix"></div>

                        <div class="post-inner"><?php the_content(); ?></div>

                        <?php if (in_category ('recipes') ){
                          // If post is a recipe addtional fields are included
                          include 'recipes-list.php';
                        } else {

                        } ?>

                    </div>

                </article>

            <?php endwhile; ?>

        <?php endif; ?>

        </section>

    </div>

    <?php get_sidebar('blog'); ?>

    <div class="clearfix"></div>




<?php  get_footer();  ?>
