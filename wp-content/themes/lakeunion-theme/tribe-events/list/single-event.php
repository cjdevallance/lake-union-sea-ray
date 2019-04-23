<?php
/**
 * Day View Single Event
 * This file contains one event in the day view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/day/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>
<?php

$venue_details = array();

if ( $venue_name = tribe_get_meta( 'tribe_event_venue_name' ) ) {
	$venue_details[] = $venue_name;
}

if ( $venue_address = tribe_get_meta( 'tribe_event_venue_address' ) ) {
	$venue_details[] = $venue_address;
}
// Venue microformats
$has_venue = ( $venue_details ) ? ' vcard' : '';
$has_venue_address = ( $venue_address ) ? ' location' : '';
?>

	<span class="feat-post-img">
		
		<?php echo tribe_event_featured_image( null, 'medium' ) ?>

		<div class="post-addy">

			<h1 class="boat-title" id="date">

				<?php echo tribe_events_event_schedule_details() ?>

				<?php if ( $venue_details ) : ?>


				<?php endif; ?>

			</h1>

		</div>

	</span>

	<div class="post-content-inner">

		<div class="post-inner">

			<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title() ?>" rel="bookmark">

				<h1 class="boat-title"><?php the_title() ?></h1>

			</a>

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
