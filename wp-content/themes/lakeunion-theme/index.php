<?php
/*
	Template Name: Home
*/

get_header(); ?>

<div class="carousel-inner" role="listbox">

	<?php while ( have_posts() ) : the_post(); if(get_field('home_hero_image')): ?>

	<?php while(has_sub_field('home_hero_image')): ?>

	<div class="item">

		<img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>">
    
		<div class="container">

			<div class="carousel-caption hidden-sm hidden-xs">

				<p class="headline"><?php the_sub_field('hero_header_1'); ?></p>

				<p class="boat-name-headline"><?php the_sub_field('hero_header_2'); ?></p>

				<p><a class="btn btn-lg btn-primary ss-feat-btn" href="#" role="button">MORE INFO <i class="fa fa-angle-right fa-lg"></i></a></p>

			</div>

		</div>

	</div>

	<?php endwhile; ?>

	<?php endif; endwhile; ?>

	<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"><img src="<?php bloginfo('template_directory'); ?>/img/slideshow-left-btn.png"></span></a>

	<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"><img src="<?php bloginfo('template_directory'); ?>/img/slideshow-right-btn.png"></span></a>

</div>

    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="inventory-search">

		<div class="container">

			<div class="content-squeeze">

				<div class="row hidden-lg">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<div class="col-xs-10">

							<span class="form-row"><p>Quick Inventory Search</p></span>

						</div>

						<div class="col-xs-2">

							<button class="formCollapse" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></button>

						</div>

					</div>

				</div>

				<form class="collapse-form collapse in" id="collapseExample">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

					<span class="form-row hidden-xs hidden-sm hidden-md"><p>Quick Inventory Search</p></span>

						<div class="form-row">

							<label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked></label>

							<span>OUR INVENTORY</span>

						</div>

					<div class="form-row">

						<label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"></label>

						<span>NORTHWEST BOAT SEARCH</span>

					</div>

				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

					<div class="form-row">

						<div class="qis-label">BRAND:</div>
    
							<div class="qis-field">

								<select class="form-control">
								<option>-- please select --</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								</select>

							</div>

							<div class="clearfix"></div>

						</div>

						<div class="form-row">

							<div class="">

								<div class="qis-label">TYPE/CATEGORY:</div>

								<div class="qis-field"><input class="form-control"></div>

							</div>

							<div class="clearfix"></div>

						</div>

						<div class="form-row">

							<div class="qis-label">LENGTH:</div>

							<div class="qis-field">

								<span class="inner-form"><input class="form-control"></span>

								<span class="inner-text">TO</span>

								<span class="inner-form"><input class="form-control"></span>

								<div class="clearfix"></div>

							</div>

							<div class="clearfix"></div>

						</div>

					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

						<div class="form-row">

							<div class="qis-label">YEAR:</div>

							<div class="qis-field">

								<span class="inner-form"><input class="form-control"></span>

								<span class="inner-text">TO</span>

								<span class="inner-form"><input class="form-control"></span>

								<div class="clearfix"></div>

							</div>

							<div class="clearfix"></div>

						</div>

						<div class="form-row">

							<div class="qis-label">PRICE:</div>

							<div class="qis-field">

								<span class="inner-form"><input class="form-control"></span>

								<span class="inner-text">TO</span>

								<span class="inner-form"><input class="form-control"></span>

								<div class="clearfix"></div>

							</div>

							<div class="clearfix"></div>

						</div>

						<div class="form-row">

							<div class="qis-label">&nbsp;</div>

							<div class="qis-field">

								<button type="submit" class="btn btn-default home-qis-submit">SUBMIT <i class="fa fa-angle-right fa-lg"></i></button>

								<div class="clearfix"></div>

							</div>

							<div class="clearfix"></div>

						</div>

					</div>

					</form>

				</div>

			</div>

		</div>

		<div class="container">

			<div class="content-squeeze">

				<div class="row section-row">

					<div id="call-text" class="hidden-md hidden-lg">

						<div class="col-xs-6 col-sm-6">

							<div class="feat-post-btn blue-btn"><a href="#">CALL US</a></div>

						</div>

						<div class="col-xs-6 col-sm-6">

							<div class="feat-post-btn blue-btn"><a href="#">TEXT US</a></div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<div class="feat-post-btn"><a href="#">SCHEDULE SERVICES</a></div>

						</div>

					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">

						<h1>Welcome to Lake Union Sea Ray</h1>

						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut quam diam, adipiscing nec consequat a, porttitor ut massa. Nulla nec nisi eget nisl pellentesque imperdiet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce id eros justo. Nullam sed purus eget ipsum pellentesque tincidunt a a tortor. Donec eu ligula eu neque feugiat sodales. Duis pretium rhoncus justo, sed laoreet sem semper at. Proin condimentum, erat mollis dictum porttitor, odio magna eleifend ligula, eu laoreet mauris felis ut quam. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nam ut erat ullamcorper tellus semper bibendum at sit amet felis.</p>

					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" id="feat-boats">

						<h3>Featured Boats</h3>

						<ul class="bxslider">

						<?php query_posts( 'cat=3' ); ?>

						<?php while ( have_posts() ) : the_post(); ?>

						<?php if(get_field('feature_boat')): ?>

						<?php while(has_sub_field('feature_boat')): ?>

						<li><a href="<?php get_sub_field( 'boat_link' ); ?> ">

						<img src="<?php $image = get_sub_field('feat_image'); echo $image['url']; ?>" class="img-responsive">

						<div class="caption1">

							<div class="pull-left">

								<span><?php $boatTitle = get_sub_field( 'boat_title' ); echo $boatTitle; ?></span>

								<span><?php $boatLocation = get_sub_field( 'boat_location' ); echo $boatLocation; ?></span>

							</div>

							<div class="pull-right" id="feat-boat-btn"><a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right fa-lg"></i></a></div>

							<div class="clearfix">&nbsp;</div>

						</div>

						</a>
						</li>

						<?php endwhile; ?>

						<?php endif; ?>

						<?php endwhile; ?>

						</ul>

					</div>

				</div>

			</div>

		</div>

		<!-- Recent News, Upcoming Events, and Current Promotions Section -->

		<div id="home-feeds-buckets">

			<div class="container">

				<section class="row hpnews">

					<?php
					$custom_args = array(
						'post_type' => 'post',
						'category_name' => 'news',
						'posts_per_page' => 1
					);
		
					$news = new WP_Query( $custom_args ); ?>

					<?php if ( $news->have_posts() ) : while ( $news->have_posts() ) : $news->the_post(); ?>

					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

						<span>

						<h2 class="pull-left">Recent News</h2>

						<span class="pull-right"><a href="<?php the_permalink(); ?>">view all ></a></span>

						<div class="clearfix"></div>

					</span>

					<div class="post-inner-home">

						<div class="clearfix"></div>

						<div class="block-casing">

							<?php if(get_field('hero_slider')) : while(has_sub_field('hero_slider')): ?>

							<a href="<?php the_permalink(); ?>"><img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive"></a>

							<?php endwhile; endif; ?>

							<div class="feat-post-content">

								<h3><?php echo get_the_title(); ?></h3>

								<p><strong><?php the_time('F jS, Y') ?></strong><br>

								<?php the_excerpt(); ?> </p>

							</div>

							<div class="feat-post-btn"><a href="<?php the_permalink(); ?>">View Full Post <i class="fa fa-angle-right fa-lg"></i></a></div>

							<div class="clearfix"></div>

						</div>

					</div>

				</article>

				<?php endwhile; endif; ?>

				<?php
				$custom_args = array(
					'post_type' => 'post',
					'category_name' => 'events',
					'posts_per_page' => 1
				);

				$events = new WP_Query( $custom_args ); ?>

				<?php if ( $events->have_posts() ) : while ( $events->have_posts() ) : $events->the_post(); ?>

				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

					<span>

					<h2 class="pull-left">Upcoming Events</h2>

					<span class="pull-right"><a href="<?php the_permalink(); ?>">view all ></a></span>

					<div class="clearfix"></div>

					</span>

					<div class="post-inner-home">

						<div class="clearfix"></div>

						<div class="block-casing">

							<?php if(get_field('hero_slider')) : while(has_sub_field('hero_slider')): ?>

							<a href="<?php the_permalink(); ?>"><img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive"></a>

							<?php endwhile; endif; ?>

							<div class="feat-post-content">

								<h3><?php echo get_the_title(); ?></h3>

								<p><strong><?php the_time('F jS, Y') ?></strong><br>

								<?php the_excerpt(); ?> </p>

							</div>

							<div class="feat-post-btn"><a href="<?php the_permalink(); ?>">View Full Post <i class="fa fa-angle-right fa-lg"></i></a></div>

							<div class="clearfix"></div>

						</div>

					</div>

				</article>

				<?php endwhile; ?>

				<?php endif ?>

				<?php
				$custom_args = array(
					'post_type' => 'post',
					'category_name' => 'promotions',
					'posts_per_page' => 1
				);

				$promo = new WP_Query( $custom_args ); ?>

				<?php if ( $promo->have_posts() ) : while ( $promo->have_posts() ) : $promo->the_post(); ?>

				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-4">

					<span>

					<h2 class="pull-left">Current Promotions</h2>

					<span class="pull-right"><a href="<?php the_permalink(); ?>">view all ></a></span>

					<div class="clearfix"></div>

					</span>

					<div class="post-inner-home">

						<div class="clearfix"></div>

						<div class="block-casing">

							<?php if(get_field('hero_slider')): ?>

							<?php while(has_sub_field('hero_slider')): ?>

							<a href="<?php the_permalink(); ?>"><img src="<?php $image = get_sub_field('hero_image'); echo $image['url']; ?>" class="img-responsive"></a>

							<?php break; endwhile; ?>

							<?php endif; ?>

							<div class="feat-post-content">

								<h3><?php echo get_the_title(); ?></h3>

								<p><strong><?php the_time('F jS, Y') ?></strong><br>

								<?php the_excerpt(); ?></p>

							</div>

							<div class="feat-post-btn"><a href="<?php the_permalink(); ?>">View Full Post <i class="fa fa-angle-right fa-lg"></i></a></div>

							<div class="clearfix"></div>

						</div>

					</div>

				</article>

				<?php endwhile; ?>

				<?php endif ?>

			</section>

		</div>

	</div>

	<div id="boat-brand-logos">

		<div class="container">

			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div id="boat-header-casing">
						<p><h1>Authorized dealer of these fine brands</h1></p>
					</div>

				</div>

				<div class="clearfix"></div>

				<ul style="padding-left: 0px" class="hpnews">
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/sea-ray-brand-logo.jpg" class="img-responsive"></a></li>
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/bayliner-brand-logo.jpg"class="img-responsive"></a></li>
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/meridian-brand-logo.jpg"class="img-responsive"></a></li>
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/boston-whaler-brand-logo.jpg" class="img-responsive"></a></li>
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/striper-brand-logo.jpg" class="img-responsive"></a></li>
				<li class="col-xs-12 col-sm-6 col-md-6 col-lg-2"><a href="#"><img src="<?php bloginfo( 'template_directory' ); ?>/img/harris-brand-logo.jpg" class="img-responsive"></a></li>
				</ul>

			</div>

		</div>

	</div>

<?php get_footer(); ?>