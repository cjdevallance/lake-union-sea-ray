<?php

/*

    Template Name: Trailers

*/

get_header(); ?>

<div class="container" id="blog">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
       <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
          <div class="spacer" style="height:20px;"></div>
        <h2>Current Inventory</h2>
          <div class="spacer" style="height:5px;"></div>  

               
         <?php query_posts('post_type=trailer'); ?>
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

               <div id="trailer-block" >
               <a href="<?php the_permalink(); ?>">

               
                <?php if(get_field('hero_slider')): ?>

                    <?php while(has_sub_field('hero_slider')): ?>

                        <img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive" /> 

                    <?php endwhile; ?>

                <?php endif; ?>


                    <h2 class="orng-hl"><?php the_field('year'); ?></h2>
                        <?php the_field('make'); ?> <?php the_field('model_name'); ?><br/>
                        MSRP: $<?php the_field('msrp'); ?>
                        </a>

               </div>

            <?php endwhile; ?>
    </div>
    
<?php get_sidebar() ?>
    
</div>


<?php get_footer(); ?>



