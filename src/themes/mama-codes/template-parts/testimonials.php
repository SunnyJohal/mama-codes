<?php
/**
 * Testimonial Full width
 *
 * Used to output the testimonial on the page.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */

// Get post metas
$background      = get_post_meta( get_the_ID(), '_diamond_testimonial_background', true );
$heading         = get_post_meta( get_the_ID(), '_diamond_testimonial_headline', true );
$category        = get_post_meta( get_the_ID(), '_diamond_testimonial_category_id', true );
$interval        = get_post_meta( get_the_ID(), '_diamond_testimonial_interval', true );
$show_thumbnails = get_post_meta( get_the_ID(), '_diamond_testimonial_show_thumbnails', true );
$hide_author     = get_post_meta( get_the_ID(), '_diamond_testimonial_hide_author', true );


// Sanitize values
$interval = $interval ? (int) esc_attr( $interval ) : 5;

// Convert interval from seconds to milliseconds
if ( is_int( $interval ) ) {
	$interval *= 1000;
} else {
	$interval = 5 * 1000;
}

// Define custom WP_Query $args
$params = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'post_type'      => 'diamond_testimonial',
	'tax_query'      => array(
							array(
								'taxonomy' => 'diamond_testimonial_category',
								'terms'    => $category
							)
						),
);

// Display all testimonials if the user hasn't selected a category
if ( -1 == $category ) {
	unset( $params['tax_query'] );
}

// Custom WP_Query
$the_query         = new WP_Query ( $params );
$i                 = 0;
$count             = 0;
$testimonial_count = 0;
?>
<?php if ( $the_query->have_posts() ) : ?>
<!-- CARD  -->
<div class="diamond-testimonial-full-width vf-card--bg vf-card-bg--<?php echo "vf-{$background}"; ?>">
	<section class="vf-card vf-feature-grid-2 <?php echo "vf-{$background}"; ?>" style="">
		<div class="container">
			<?php if ( $heading ) : ?>
				<div class="row tt-card--heading-row tt-typography--text-center mb32 mb-xs-24">
					<div class="col-md-10 col-md-push-1 tt-card--heading">
						<?php if ( $heading ): ?>
							<h1 class="tt-card--headline tt-typography--font-medium mt0 mb8"><?php echo $heading; ?></h1>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-12">
					<div class="etb-testimonial-carousel carousel slide" id="etb-testimonial-carousel-full-<?php echo $testimonial_count; ?>" data-ride="carousel" data-interval="<?php echo $interval; ?>">

						<!-- Carousel indicators -->
						<ol class="carousel-indicators">
							<?php while ( $i < $the_query->found_posts ) : ?>
								<?php $active_class = 0 === $i ? 'active' : ''; ?>
								<li class="<?php echo $active_class; ?>" data-target="#etb-testimonial-carousel-full-<?php echo $testimonial_count; ?>" data-slide-to="<?php echo $i; ?>"></li>
								<?php $i++; ?>
							<?php endwhile; ?>
						</ol>

						<!-- Carousel items -->
						<div class="carousel-inner">
							<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
								<?php $active = ( 0 == $count ) ? 'active' : ''; ?>
								<div class="item <?php echo $active; ?>">

									<?php if ( has_post_thumbnail() && $show_thumbnails ) : ?>

										<div class="profile-circle" style="">
											<?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-circle' ) ); ?>
										</div>
									<?php endif ?>

									<div class="etb-testimonial-content"><?php the_content(); ?></div>

									<?php if ( ! $hide_author ): ?>
										<div class="etb-author"><?php the_title(); ?></div>
									<?php endif ?>

								</div>
							<?php $count++; endwhile; ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="tt-clear clearfix"></div>
<?php wp_reset_postdata(); ?>
<?php endif; ?>
