<?php
/**
 * Big Slider
 *
 * The template part to output the big cover
 * slider on the homepage.
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 * 
 */

$args = array(
	'post_type'      => 'slides',
	'posts_per_page' => 10,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
);

$slides = new WP_Query( $args );
?>


	<section class="cd-hero js-cd-hero js-cd-autoplay">
		<ul class="cd-hero__slider">
			<li class="cd-hero__slide cd-hero__slide--selected js-cd-slide" style="background-image:url(https://212.67.220.56/wp-content/uploads/2018/03/Logos.jpg);">
				<div class="cd-hero__content cd-hero__content--full-width">
					<h2>Hero slider</h2>
					<p>A simple, responsive slideshow in CSS &amp; JavaScript.</p>
					<a href="http://codyhouse.co/gem/hero-slider/" class="cd-hero__btn">Article &amp; Download</a>
				</div> <!-- .cd-hero__content -->
			</li>

			<li class="cd-hero__slide js-cd-slide" style="background-image:url(https://212.67.220.56/wp-content/uploads/2018/04/Rep-team-768x549.png);">
				<div class="cd-hero__content cd-hero__content--full-width">
					<h2>Number 2</h2>
					<p>A simple, responsive slideshow in CSS &amp; JavaScript.</p>
					<a href="http://codyhouse.co/gem/hero-slider/" class="cd-hero__btn">Article &amp; Download</a>
				</div> <!-- .cd-hero__content -->
			</li>
		</ul> <!-- .cd-hero__slider -->

		<div class="cd-hero__nav js-cd-nav">
		</div> <!-- .cd-hero__nav -->
	</section> <!-- .cd-hero -->
<a href="#" class="btn btn-primary prev">Prev</a>
<a href="#" class="btn btn-primary next">Next</a>

<?php return; ?>
<!-- Output the slider -->
<section class="cover fullscreen image-slider mc-slider slider-all-controls controls-inside">
	<div class="mc-slider--decoration"></div>
	<?php if ( $slides->have_posts() ) : ?>
		<div class="flexslider">
			<ul class="slides">
				<?php while ( $slides->have_posts() ) : $slides->the_post(); ?>
					<?php
						// Slide Props.
						$subtitle       = get_post_meta( get_the_ID(), '_aeq_page_subtitle', true );
						$btn_text       = get_post_meta( get_the_ID(), 'slider_button_text', true );
						$btn_link       = get_post_meta( get_the_ID(), 'slider_meta_box_link', true );
						$btn_text       = empty( $btn_text ) ? 'Find out more': $btn_text;
						$btn_link       = empty( $btn_link ) ? '':              esc_url( $btn_link );
						$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
					?>
					<li>
						<img alt="image" class="background-image" src="<?php the_post_thumbnail_url(); ?>">
						<div class="flex-caption">
							<h1><?php the_title(); ?></h1>
						</div>
					</li>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</ul>
		</div>
	<?php endif; ?>
</section>
