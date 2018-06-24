<?php
/**
 * Header
 * 
 * Loads the document </head> and navigation.
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 * 
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php visualcomposerstarter_hook_after_head(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head() ?>
</head>
<body <?php body_class( 'fixed-header' ); ?>>
<?php if ( visualcomposerstarter_is_the_header_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_header(); ?>

	<!-- Header -->
	<header id="header">
		<nav class="navbar navbar-fixed mdc-elevation--z1">
			<div class="<?php echo esc_attr( visualcomposerstarter_get_header_container_class() ); ?>">
				<div class="navbar-wrapper clearfix">
					<div class="navbar-header">
						<div class="navbar-brand">
							<?php
							if ( has_custom_logo() ) :
								the_custom_logo();
							else : ?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
									<img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/mama-codes-logo.png'; ?>" />
								</a>
							<?php endif; ?>

						</div>

						<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<button type="button" class="navbar-toggle">
								<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'visual-composer-starter' ) ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						<?php endif; ?>
					</div>
					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<div id="main-menu">
							<div class="button-close"><span class="vct-icon-close"></span></div>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary',
								'menu_class'     => 'nav navbar-nav',
								'container'      => '',
							) );
							?>
							<div class="header-widgetised-area">
							<?php if ( is_active_sidebar( 'menu' ) ) : ?>
								<?php dynamic_sidebar( 'menu' ); ?>
							<?php endif; ?>
							</div>
						</div><!--#main-menu-->
					<?php endif; ?>
				</div><!--.navbar-wrapper-->
			</div><!--.container-->
		</nav>
			<?php if ( is_singular() ) : ?>
			<div class="header-image">
				<?php visualcomposerstarter_header_featured_content(); ?>
			</div>
			<?php endif; ?>
	</header>
	<?php visualcomposerstarter_hook_after_header(); ?>
<?php endif; ?>
<?php 
	/**
	 * Get Page Title
	 * 
	 * Fetches the page title to output on each page.
	 * 
	 */
	get_template_part( 'template-parts/title', get_post_format() ); 
