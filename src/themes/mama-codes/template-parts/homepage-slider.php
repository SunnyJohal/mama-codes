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

$count = 0;
$slides = new WP_Query( $args );
?>


	<section class="cd-hero js-cd-hero js-cd-autoplay">
		<?php if ( $slides->have_posts() ) : ?>
			<ul class="cd-hero__slider">
				<?php while ( $slides->have_posts() ) : $slides->the_post(); ?>
					<?php
						// Slide Props.
						$subtitle       = get_post_meta( get_the_ID(), 'slider_subtitle', true );
						$bg_pos         = get_post_meta( get_the_ID(), 'slider_background_position', true );
						$btn_text       = get_post_meta( get_the_ID(), 'slider_button_text', true );
						$btn_link       = get_post_meta( get_the_ID(), 'slider_meta_box_link', true );
						$btn_text       = empty( $btn_text ) ? 'Find out more' : $btn_text;
						$btn_link       = empty( $btn_link ) ? '' : esc_url( $btn_link );
						$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
					?>
					<li class="cd-hero__slide js-cd-slide <?php echo $count === 0 ? 'cd-hero__slide--selected' : ''; ?>" style="background-image:url(<?php echo $feat_image_url; ?>); <?php echo $bg_pos ? "background-position: {$bg_pos}" : ''; ?>">
						<div class="cd-hero__content cd-hero__content--full-width">
							<h2><?php the_title(); ?></h2>

							<?php if ( $subtitle ) : ?>
								<p><?php echo $subtitle; ?></p>
							<?php endif; ?>

							<?php if ( $btn_link ) : ?>
								<a href="<?php echo esc_url( $btn_link ); ?>" class="cd-hero__btn"><?php echo $btn_text; ?></a>
							<?php endif; ?>
						</div> <!-- .cd-hero__content -->
					</li>					
				<?php $count++; endwhile; ?>

				<!-- <li class="cd-hero__slide cd-hero__slide--selected js-cd-slide" style="background-image:url(https://212.67.220.56/wp-content/uploads/2018/03/Logos.jpg);">
					<div class="cd-hero__content cd-hero__content--full-width">
						<h2>Slide 1</h2>
						<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Necessitatibus, voluptatibus.</p>
						<a href="http://codyhouse.co/gem/hero-slider/" class="cd-hero__btn">Article &amp; Download</a>
					</div> 
				</li> -->
			</ul> <!-- .cd-hero__slider -->
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>

		<!-- Nav used as pattern footer, do not edit. -->
		<div class="cd-hero__nav js-cd-nav">
		</div>

		<!-- Pagination -->
		<a href="#" class="btn btn-primary prev mc-slider-nav--prev">&#8592;</a>
		<a href="#" class="btn btn-primary next mc-slider-nav--next">&#8594;</a>
	</section> <!-- .cd-hero -->
