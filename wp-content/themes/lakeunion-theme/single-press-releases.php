<?php
/*
Template Name: Press Releases Template
*/
get_header( 'sub' ); ?>

<div class="container">

    <div class="col-lg-12">

		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

			<section id="promo-posts">
            
            	<h1><?php the_title(); ?></h1>

				<div class="clearfix"></div>

				<?php query_posts("cat=16&posts_per_page=100&order=dsc"); 
				if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<article class="single-post">

					<div class="post-content-single">

						<h2><?php the_title(); ?></h2>

						<div class="clearfix"></div>
                        
                        <div class="post-image">
							<?php if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'category-thumb' );
                            //} else { ?>
                            <!--<img src="<?php bloginfo( 'template_url' ); ?>/images/default-image.jpg" alt="<?php //the_title(); ?>">-->
                            <?php } ?>
						</div>

						<div class="post-inner">
							<?php the_content(); ?>
                        </div>

					</div>

				</article>
                
                <hr class="styled">

				<?php endwhile; ?>

			</section>

		</div>

		<?php get_sidebar(); ?>

    </div>

</div>

<?php if ( wp_is_mobile() ) { get_footer( 'mobile'); } else { get_footer(); } ?>
