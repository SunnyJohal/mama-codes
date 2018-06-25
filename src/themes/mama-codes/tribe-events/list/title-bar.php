<?php
/**
 * List View Title Template
 * The title template for the list view of events.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/title-bar.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 * @since   4.6.19
 *
 */

// Bail if we are on the 'tribe_events' archive page
// as we are handling that title in the title
// template.
if ( is_post_type_archive( 'tribe_events' ) ) {
	return;
}
?>

<div class="tribe-events-title-bar">
	<!-- List Title -->
	<?php do_action( 'tribe_events_before_the_title' ); ?>
	<h1 class="tribe-events-page-title"><?php echo tribe_get_events_title() ?></h1>
	<?php do_action( 'tribe_events_after_the_title' ); ?>

</div>
