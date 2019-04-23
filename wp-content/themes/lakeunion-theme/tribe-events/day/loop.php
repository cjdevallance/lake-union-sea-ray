


<?php while ( have_posts() ) : the_post(); ?>
	
		<?php tribe_get_template_part( 'day/single', 'event' ) ?>
	
<?php endwhile; ?>

