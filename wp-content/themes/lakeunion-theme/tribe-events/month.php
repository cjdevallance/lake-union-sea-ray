
<?php do_action( 'tribe_events_before_template' ) ?>

<!-- Tribe Bar -->

<?php tribe_get_template_part( 'modules/bar' ); ?>

<!-- Main Events Content -->
<?php tribe_get_template_part( 'month/content' ); ?>

<?php do_action( 'tribe_events_after_template' ) ?>
