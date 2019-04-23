<?php

/*

    Template name: Meet The Team

*/

get_header(); ?>

<div class="container">
    <div class="col-lg-12 single-post-header">

      <h1><?php the_title(); ?></h1>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
    <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>

        <section id="promo-posts">

        <article>
            <?php the_content(); ?>
        </article>

        <hr/>
        <div class="clearfix"></div>

        <article>

                
                <?php if ( have_rows( 'display_list' ) ): ?>

                      <?php while ( have_rows ( 'display_list' ) ) : the_row();

                      //var
                      $list_image = get_sub_field('list-image');
                      $list_name = get_sub_field('list_name');
                      $list_title = get_sub_field('list_title');
                      $list_content = get_sub_field('list_content');

                      ?>

                    <div class="row">
                        
                    <div class="col-lg-3">

                    <span class="image_border">
                    
                    <img src="<?php echo $list_image['url']; ?>" class="img-responsive" />

                    </span>

                    </div>

                    <div class="col-lg-9">
                        
                    <h2 class="team-name"><?php echo $list_name; ?></h2> <h2 class="team-title"> - <?php echo $list_title; ?></h2>
                    <div class="clearfix" ></div>
                    <?php echo $list_content; ?>

                    </div>

                    </div>

                    <hr/>


                    <?php endwhile; ?>

                <?php endif; ?>


            <?php endwhile; ?>

        <?php endif; ?>

        </article>

        </section>

    </div>

    <?php get_sidebar(); ?>

    <div class="clearfix"></div>

</div>


<?php  get_footer();  ?>
