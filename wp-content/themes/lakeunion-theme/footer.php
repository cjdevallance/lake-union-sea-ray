<footer>

	<div class="container">

		<div class="row">

			<div id="footer-content" class="col-xs-12 col-sm-4 col-md-4 col-lg-3 footer-logo">

				<span id="lusr-logo"><img src="<?php bloginfo( 'template_directory' ); ?>/img/sea-ray-logo-white.png" alt="Lake Union Sea Ray logo" class="img-responsive"/></span>

				<p class="copyright">©2015 Lake Union Sea Ray<br>
				Privacy Policy | Site Map<br>
				Site by <a href="http://dominionmarinemedia.com/portfolio" target="new">Dominion Marine Media</a></p>

				<hr>

				<h4>Get Connected:</h4>

				<ul id="social-sprite">
				<li><a id="facebook" href="#">&nbsp;</a></li>
				<li><a id="twitter" href="#">&nbsp;</a></li>
				<li><a id="youtube" href="#">&nbsp;</a></li>
				<li><a id="googleplus" href="#">&nbsp;</a></li>
				<li><a id="pinterest" href="#">&nbsp;</a></li>
				<li><a id="blog" href="#">&nbsp;</a></li>
				</ul>

				<hr>

				<h4>experience boating with our blog:</h4>

                <span id="blog-logo-footer"><img src="<?php bloginfo( 'template_directory' ); ?>/img/blog-logo.png" class="img-responsive"></span>

			</div>

			<div class="col-xs-12 col-sm-4 col-md-3 col-md-3 hidden-xs hidden-sm hidden-md footer-links">

				<h4>browse our site:</h4>

				<?php
				wp_nav_menu( array(
					'menu'              => 'Footer',
					'theme_location'    => 'Footer',
					'depth'             => 2,
					'container'         => 'div',
					'container_class'   => 'collapse navbar-collapse footer-links',
					'container_id'      => 'bs-example-navbar-collapse-1',
					'menu_class'        => 'nav navbar-nav footer_nav',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker())
				);
				?>

            </div>

            <div id="footer-content" class="col-xs-12 col-sm-4 col-md-3 col-md-3 footer-links footer-news">

				<div class="hidden-lg hidden-sm hidden-md"><hr></div>

				<h4>latest News</h4>

				<section>
    
					<?php $news = new WP_Query( 'cat=8&posts_per_page=1' ); ?>

					<?php if ( $news->have_posts() ) : while ( $news->have_posts() ) : $news->the_post(); ?>

					<article>

						<a href="<?php the_permalink(); ?>"><h5><?php the_title(); ?></h5></a>

						<?php //the_excerpt(); ?>

						<p><a href="<?php the_permalink(); ?>">read more ></a></p>

					</article>
                    
                    <hr class="footer-hr">

					<?php endwhile; ?>

					<?php endif; ?>

				</section>

			</div>

			<div id="footer-content" class="col-xs-12 col-sm-4 col-md-3 col-md-3 footer-links footer-locations">

				<div class="hidden-lg hidden-sm hidden-md"><hr></div>

				<h4>Contact Us:</h4>

				<section id="contact-styles">

					<article>

						<span class="location-name">Seattle, WA - Sales &amp; Service</span><br>
						<span class="location-address">3201 Fairview Ave East<br>
						Seattle, WA 98102<br>

						<span class="hidden-xs hidden-sm hidden-md">Phone:</span> (206) 284-3800<br>

						<a href="https://goo.gl/maps/NyKYl" target="_blank">directions</a>  | <a href="#">text us</a></span>

					</article>

					<article>

                        <span class="location-name">Fife, WA - Sales &amp; Service</span><br>
						<span class="location-address">7700 Pacific Highway East <br>
						Milton, WA 98354 <br>

						<span class="hidden-xs hidden-sm hidden-md">Phone:</span> (253) 922-4849<br>

						<a href="https://goo.gl/maps/Y0X3x" target="_blank">directions</a>  | <a href="#">text us</a></span>

					</article>

					<article>

						<span class="location-name">Bellingham, WA - Sales</span><br>
						<span class="location-address">2121 Roeder Avenue <br>
						Bellingham, WA 98225 <br>

						<span class="hidden-xs hidden-sm hidden-md">Phone:</span> (360) 671-5560<br>

						<a href="https://goo.gl/maps/71zma" target="_blank">directions</a>  | <a href="#">text us</a></span>

					</article>

					<article>

						<span class="location-name">Bellingham, WA - Service</span><br>
						<span class="location-address">806 Marine Drive<br>
						Bellingham, WA 98225<br>

						<a href="https://goo.gl/maps/CisbD" target="_blank">directions</a>  | <a href="#">text us</a></span>

					</article>

				</section>

			</div>

		</div>

	</div>

</footer>

<?php wp_footer(); ?>

<script type="text/javascript">
$('#gallery').galleria({
width: 700,
height: 467 //--I made heights match
});
</script>

</body>
</html>