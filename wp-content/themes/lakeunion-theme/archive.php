<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package LakeUnionSeaRay
 */

get_header(); ?>

<div class="container" id="blog">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">

		<section>
				<article>

					<?php
					$categories = get_the_category();
					$separator = ' ';
					$output = '';
					if($categories){
						foreach($categories as $category) {
							$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
						}
					echo trim($output, $separator);
					}
					?>

						<?php
		$args = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'style'              => 'list',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => 13,
		'feed'               => '',
		'feed_type'          => '',
		'feed_image'         => '',
		'exclude'            => '',
		'exclude_tree'       => '',
		'include'            => '',
		'hierarchical'       => 1,
		'title_li'           => __( '' ),
		'show_option_none'   => __( '' ),
		'number'             => null,
		'echo'               => 1,
		'depth'              => 0,
		'current_category'   => 0,
		'pad_counts'         => 0,
		'taxonomy'           => 'category',
		'walker'             => null,
		);
		wp_list_categories( $args );
?>

				</article>
		</section>

		<section id="promo-posts">

				<?php

				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

				$custom_args = array(
						'post_type' => 'post',
						'category_name' => 'blog',
						'posts_per_page' => 6,
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

																<a href=" <?php the_permalink(); ?> "><h1 class="boat-title"></h1> <h1><?php the_title(); ?></h1></a>

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
