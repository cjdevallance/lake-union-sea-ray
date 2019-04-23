

	<?php while ( have_posts() ) : the_post(); ?>


		<!-- Month / Year Headers -->
		<?php tribe_events_list_the_date_headers(); ?>

		<!-- Event  -->
		<div id="post-<?php the_ID() ?>" class="<?php tribe_events_event_classes() ?>">
			<?php tribe_get_template_part( 'list/single', 'event' ) ?>
		</div><!-- .hentry .vevent -->


	<?php endwhile; ?>

