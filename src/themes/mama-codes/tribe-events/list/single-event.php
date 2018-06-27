<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @version 4.6.19
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Disable recurring info tooltips.
if ( class_exists( 'Tribe__Events__Pro__Main' ) ) {
	$ecp = Tribe__Events__Pro__Main::instance();
	$ecp->disable_recurring_info_tooltip();
}

$custom_fields = array();

if ( function_exists( 'tribe_get_custom_fields' ) ) {
	$custom_fields = tribe_get_custom_fields();
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// The address string via tribe_get_venue_details will often be populated even when there's
// no address, so let's get the address string on its own for a couple of checks below.
$venue_address = tribe_get_address();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

// Location Categories
$location_terms = wp_get_post_terms( get_the_id(), 'tribe_events_cat' );

?>

<!-- Custom Event Layout -->
<div class="mc-event--card mdc-elevation--z1">

	<!-- Event details .row-eq-height for equal height columns-->
	<div class="row ">
		<!-- Event Title -->
		<div class="col-sm-12">
			<div class="mc-event--card--wrapper">

				<h3 class="tribe-events-list-event-title">
					<a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
						<?php the_title() ?>
					</a>
				</h3>


				<?php if ( tribe_get_recurrence_text( get_the_id() ) ) : ?>
					<div class="mc-event--recurrance-text">
						<span>
							<?php echo tribe_get_recurrence_text( get_the_id() ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php do_action( 'tribe_events_after_the_event_title' ) ?>

				<!-- Schedule & Recurrence Details -->
				<div class="tribe-event-schedule-details">
					Next class: <?php echo str_replace( '@', 'at', tribe_events_event_schedule_details() ); ?>
				</div>

				<?php
					/**
					 * Fetch in Additional Fields
					 */
					if ( function_exists( 'tribe_get_custom_fields' ) ) {
						tribe_get_template_part( 'pro/modules/meta/additional-fields', null, array(
							'fields' => tribe_get_custom_fields(),
						) );
					}
				?>
			</div>
		</div>

		<!-- Google Map -->
		<div class="col-sm-12">
			<div class="mc-event--card--wrapper mc-event--card-address">
				<!-- Event Meta -->
				<?php do_action( 'tribe_events_before_the_meta' ) ?>
				
				<!-- Custom event categories -->
				<?php if ( ! is_wp_error( $location_terms ) ) : ?>
					<div class="mc-event--area">
						<?php foreach ( $location_terms as $location_term ) : ?>
							<div class="mc-event--area-details">
								<h2 class="mc-event--area-heading"><?php echo $location_term->name; ?></h2>
								<a class="mc-event--area-link" href="<?php echo get_term_link( $location_term ); ?>">See all events in this area</a>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<div class="tribe-events-event-meta">
					<div class="author <?php echo esc_attr( $has_venue_address ); ?>">
	
						<?php if ( $venue_details ) : ?>
							<!-- Venue Display Info -->
							<div class="tribe-events-venue-details">
							<?php
								$address_delimiter = empty( $venue_address ) ? ' ' : ', ';
	
								// These details are already escaped in various ways earlier in the process.
								echo implode( $address_delimiter, $venue_details );
	
								if ( tribe_show_google_map_link() ) {
									echo tribe_get_map_link_html();
								}
							?>
							</div> <!-- .tribe-events-venue-details -->
						<?php endif; ?>
					</div>
				</div><!-- .tribe-events-event-meta -->
				<?php do_action( 'tribe_events_after_the_meta' ) ?>

				<?php // tribe_get_template_part( 'modules/meta/map' ); ?>
			</div>
		</div>

		<!-- Price & Call to Action -->
		<div class="col-sm-12 mc-event--card-cta">
			<div class="mc-event--card--wrapper">
				<!-- Event Cost -->
				<div>
					<?php if ( ! empty( $custom_fields['Trial Available'] ) ) : ?>
						<?php 
							$a = new SimpleXMLElement( $custom_fields['Trial Available'] );
							$url = $a['href'];
						?>
						<a href="<?php echo $url; ?>" class="tribe-events-read-more btn btn-lg btn-info">Book a trial</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more btn btn-lg btn-success" rel="bookmark"><?php esc_html_e( 'Book a block', 'the-events-calendar' ) ?></a>
				</div>
				<?php if ( tribe_get_cost() ) : ?>
					<div class="tribe-events-event-cost">
						<span class="ticket-cost"><?php echo tribe_get_cost( null, true ); ?></span>
						<?php
						/**
						 * Runs after cost is displayed in list style views
						 *
						 * @since 4.5
						 */
						do_action( 'tribe_events_inside_cost' )
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
