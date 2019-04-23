<?php
/*
Template Name: Internal Page Template
*/
get_header( 'sub' ); ?>

<div class="container">

    <div class="col-lg-12">

		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

			<section id="promo-posts">

				<div class="clearfix"></div>

				<?php if ( have_posts() ) : ?>

            	<?php while ( have_posts() ) : the_post(); ?>

				<article class="single-post">

					<div class="post-content-single">

						<h1><?php the_title(); ?></h1>

						<div class="clearfix"></div>

						<div class="post-inner"><?php the_content(); ?></div>
                        
                        <?php if ((is_page( 113 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-trade-in-eval.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( 123 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-schedule-service.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( 125 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-order-parts.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( 121 ))) { ?>
                        
						<a class="payment-calculator-button" href="<?php bloginfo( 'url' ); ?>/finance/payment-calculator/">Payment Calculator <i class="fa fa-angle-right fa-lg"></i></a>
                        <a class="credit-application-button" href="<?php bloginfo( 'url' ); ?>/finance/credit-application/">Credit Application <i class="fa fa-angle-right fa-lg"></i></a>
						
						<? } ?>
                        
                        <?php if ((is_page( 133 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-payment-calculator.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( 135 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-credit-application.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( 145 ))) { ?>
                        
						<?php include('wp-content/themes/lakeunion-theme/inc/form-application.php'); ?>
						
						<? } ?>
                        
                        <?php if ((is_page( array( 151, 153, 155, 675 )))) { ?>
                        
						<?php if(get_field('address')): ?>
    
                        <div id="contact-page">
                        
                            <div class="contact-map">
                            
								<?php
                                $location = get_field('google_map');
                                if( ! empty($location) ):
                                ?>
                                
                                <div id="map" style="width: 100%; height: 350px;"></div>
                                
                                <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
                                
                                <script type="text/javascript">
                                    function load() {
                                    var lat = <?php echo $location['lat']; ?>;
                                    var lng = <?php echo $location['lng']; ?>;
                                // coordinates to latLng
                                    var latlng = new google.maps.LatLng(lat, lng);
                                // map Options
                                    var myOptions = {
                                    zoom: 9,
                                    center: latlng,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                   };
                                //draw a map
                                    var map = new google.maps.Map(document.getElementById("map"), myOptions);
                                    var marker = new google.maps.Marker({
                                    position: map.getCenter(),
                                    map: map
                                   });
                                }
                                   load();
                                </script>
                                
								<?php endif; ?>
                            
                            </div>
                            
                            <div class="contact-3-columns">
                            
                            	<div class="address-container">
                                <div class="contact-address"><?php echo get_post_meta($post->ID, 'address', true); ?></div>
                                
                                <hr class="styled2">
                            
                                <div class="contact-local-phone">Phone: <?php echo get_post_meta($post->ID, 'local_phone', true); ?></div>
                            
                                <div class="contact-toll-free">Toll Free: <?php echo get_post_meta($post->ID, 'toll_free_phone', true); ?></div>
                            
                                <div class="contact-fax">Fax: <?php echo get_post_meta($post->ID, 'fax', true); ?></div>
                            
                                <a class="contact-directions" href="<?php echo get_post_meta($post->ID, 'directions', true); ?>" target="new">directions</a> &nbsp; | &nbsp; 
                            
                                <a class="contact-text-us" href="<?php echo get_post_meta($post->ID, 'text_us', true); ?>">text us</a>
                            
                            </div>
    
                            	<div class="sales-container">
                            
                                <div class="contact-sales-title">Business Hours</div>
                                
                                <div class="contact-sales-hours">
                                
                                    <?php
                                    if( have_rows('business_hours') ):
                                    while ( have_rows('business_hours') ) : the_row(); ?>
                            
                                    <span class="date">Monday: </span><span class="hours"><?php echo the_sub_field('monday'); ?></span><br>
                                    <span class="date">Tuesday: </span><span class="hours"><?php echo the_sub_field('tuesday'); ?></span><br>
                                    <span class="date">Wednesday: </span><span class="hours"><?php echo the_sub_field('wednesday'); ?></span><br>
                                    <span class="date">Thursday: </span><span class="hours"><?php echo the_sub_field('thursday'); ?></span><br>
                                    <span class="date">Friday: </span><span class="hours"><?php echo the_sub_field('friday'); ?></span><br>
                                    <span class="date">Saturday: </span><span class="hours"><?php echo the_sub_field('saturday'); ?></span><br>
                                    <span class="date">Sunday: </span><span class="hours"><?php echo the_sub_field('sunday'); ?></span>
                            
                                    <?php endwhile;
                                    else :
                                    endif;
                                    ?>
                                </div>
                                
                            </div>
    
                            	<div class="service-container">
                            
                                <div class="contact-sales-title">Service Hours</div>
                                
                                <div class="contact-sales-hours">
                                
                                    <?php
                                    if( have_rows('service_hours') ):
                                    while ( have_rows('service_hours') ) : the_row(); ?>
                            
                                    <span class="date">Monday: </span><span class="hours"><?php echo the_sub_field('monday'); ?></span><br>
                                    <span class="date">Tuesday: </span><span class="hours"><?php echo the_sub_field('tuesday'); ?></span><br>
                                    <span class="date">Wednesday: </span><span class="hours"><?php echo the_sub_field('wednesday'); ?></span><br>
                                    <span class="date">Thursday: </span><span class="hours"><?php echo the_sub_field('thursday'); ?></span><br>
                                    <span class="date">Friday: </span><span class="hours"><?php echo the_sub_field('friday'); ?></span><br>
                                    <span class="date">Saturday: </span><span class="hours"><?php echo the_sub_field('saturday'); ?></span><br>
                                    <span class="date">Sunday: </span><span class="hours"><?php echo the_sub_field('sunday'); ?></span>
                            
                                    <?php endwhile;
                                    else :
                                    endif;
                                    ?>
                                    
                                </div>
                                
                            </div>
                            
                            </div>
                            
                            <hr class="styled">
    
							<div class="contact-photo">
								<img src="<?php $image = get_field('hero_image'); echo $image['url']; ?>">
							</div>                          
 
                            <div class="contact-about">
                                
                                <div class="contact-about-title">About This Location</div>
                        
                                <?php echo get_post_meta($post->ID, 'about_this_location', true); ?>
                                
                            </div>
                                                        
                            <a class="contact-button" href="<?php echo get_post_meta($post->ID, 'view_this_locations_inventory', true); ?>">View This Location's Inventory <i class="fa fa-angle-right fa-lg"></i></a>
                        </div>
                        
                        <?php endif; ?>
						
						<? } ?>

					</div>

				</article>

				<?php endwhile; ?>

				<?php endif; ?>

			</section>

		</div>

		<?php get_sidebar(); ?>

    </div>

</div>

<?php if ( wp_is_mobile() ) { get_footer( 'mobile'); } else { get_footer(); } ?>