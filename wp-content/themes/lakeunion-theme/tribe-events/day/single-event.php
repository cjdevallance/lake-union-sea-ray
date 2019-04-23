

<!-- ********* Start of Custom Style ( I DON'T KNOW WHY BUT DONT DELETE THIS SECTION )************ 

<article class="single-post">

   
    <div class="post-content-inner">

        <div class="post-inner">
        
        <a href=" <?php the_permalink(); ?> "><h1 class="boat-title"></h1></a>

        <?php the_excerpt(); ?>

        </div>

        <a href=" <?php the_permalink(); ?> " class="post-more-btn">MORE INFO</a>

    </div>

    <div class="clearfix"></div>

</article>


 ********* End of Custom Style ************ -->







	<span class="feat-post-img">

		<?php echo tribe_event_featured_image( null, 'medium' ) ?>

	</span>

	<div class="post-content-inner">

		<div class="post-inner">

			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title() ?>" rel="bookmark">

				<h1 class="boat-title"><?php the_title() ?></h1>

			</a>
			<h1 class="boat-title" id="date">

				<?php echo tribe_events_event_schedule_details() ?>

				<?php if ( $venue_details ) : ?>

				<?php echo implode( ', ', $venue_details ); ?>

				<?php endif; ?>

			</h1>

			<div class="clearfix"></div>

			<div class="post-exp">

			<?php the_excerpt(); ?>

			<a class="post-more-btn" href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more" rel="bookmark">

				<?php _e( 'MORE INFO', 'tribe-events-calendar' ) ?>

			</a>

			</div>
		</div>

		
	</div>


	<div class="clearfix"></div>

  
