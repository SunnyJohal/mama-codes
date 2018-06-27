<?php
/**
 * Single Event Meta (Additional Fields) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/pro/modules/meta/additional-fields.php
 *
 * @package TribeEventsCalendarPro
 * @version 4.4.28
 */

if ( ! isset( $fields ) || empty( $fields ) || ! is_array( $fields ) ) {
	return;
}

// Field count.
$count = 0;

?>

<div class="tribe-events-meta-group tribe-events-meta-group-other">
	<h2 class="tribe-events-single-section-title"> <?php esc_html_e( 'Code club details', 'tribe-events-calendar-pro' ) ?> </h2>

	<table class="table table-striped table-bordered table-responsive">
		<tbody>
			<?php foreach ( $fields as $name => $value ) : ?>
				<?php 
					if ( 'Trial Available' === $name ) {
						continue;
					}
				?>
				<tr>
					<td class="tribe-meta-label">
						<?php echo esc_html( $name );  ?>
					</td>
					<td class="tribe-meta-value">
						<?php
							// This can hold HTML. The values are cleansed upstream
							echo $value;
						?>					
					</td>
				</tr>
			<?php $count++; endforeach; ?>
		</tbody>
	</table>
</div>
