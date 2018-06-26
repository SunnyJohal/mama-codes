<?php
/**
 * Page Title
 *
 * Displays the default page title on each page.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */

$frontend = TT_Frontend::get_instance();
$context  = $frontend->get_context();
$template = TT_Template::get_instance();

if ( is_home() || is_front_page() ) {
	get_template_part( 'template-parts/homepage-slider' );
	get_template_part( 'template-parts/title-home' );
	return;
}
?>


<!-- Title Markup -->
<div class="mc-title--bg">
	<div class="mc-title--overlay">
		<div class="mc-title--container container">
			<div class="mc-title--wrap">
				<div class="row">
					<!-- Social Navigation -->
					<div class="col-xs-12 col-sm-4 col-md-4 col-sm-push-8 col-md-push-8">
						<?php if ( get_theme_mod( 'vct_footer_area_social_icons', false ) ) : ?>
							<div class="header-right-block pull-right">
								<div class="header-socials">
									<ul>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_facebook', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_facebook', '' ) ); ?>"><span class="vct-icon-facebook-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_twitter', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_twitter', '' ) ); ?>"><span class="vct-icon-twitter-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_linkedin', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_linkedin', '' ) ); ?>"><span class="vct-icon-linkedin-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_instagram', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_instagram', '' ) ); ?>"><span class="vct-icon-instagram-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_pinterest', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_pinterest', '' ) ); ?>"><span class="vct-icon-pinterest-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_youtube', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_youtube', '' ) ); ?>"><span class="vct-icon-youtube-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_vimeo', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_vimeo', '' ) ); ?>"><span class="vct-icon-vimeo-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_flickr', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_flickr', '' ) ); ?>"><span class="vct-icon-flickr-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_github', '' ) ) ) : ?>
											<li>
												<a target="_blank" href="<?php echo esc_url( get_theme_mod( 'vct_footer_area_social_link_github', '' ) ); ?>"><span class="vct-icon-github-with-circle"></span></a>
											</li>
										<?php endif; ?>
										<?php if ( strlen( get_theme_mod( 'vct_footer_area_social_link_email', '' ) ) ) : ?>
											<li>
												<a href="<?php echo esc_url( 'mailto:' . antispambot( get_theme_mod( 'vct_footer_area_social_link_email', '' ) ) ); ?>"><span class="vct-icon-mail-circle"></span></a>
											</li>
										<?php endif; ?>

									</ul>
								</div>
							</div>
						<?php endif; ?>
						<div class="clearfix"></div>
					</div>

					<!-- Title and Breadcrumbs -->
					<div class="col-xs-12 col-sm-8 col-md-8 col-sm-pull-4 col-md-pull-4">
						<?php echo $template->get_breadcrumbs(); ?>
						<h1 class="page-header"><?php echo $template->get_the_title(); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




