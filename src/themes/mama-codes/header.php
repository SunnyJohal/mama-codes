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
$login_url = wp_login_url();
$logout_url = wp_logout_url();

$action_link = is_user_logged_in() ? "<a href='{$logout_url}'>Logout</a>" : "<a href='{$login_url}'>Login</a>";
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php visualcomposerstarter_hook_after_head(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified JavaScript -->
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

						<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'primary_logged_in' ) ) : ?>
							<button type="button" class="navbar-toggle">
								<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'visual-composer-starter' ) ?></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						<?php endif; ?>
					</div>
					
					<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'primary_logged_in' ) ) : ?>
					<div id="main-menu">
						<div class="button-close"><span class="vct-icon-close"></span></div>
						<?php

								wp_nav_menu( array(
									'theme_location' => is_user_logged_in() ? 'primary_logged_in' : 'primary',
									'menu_class'     => 'nav navbar-nav',
									'container'      => '',
									'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s<li>' . $action_link . '</li></ul>',
									) );
									?>
						</div><!--#main-menu-->
						<div class="mobile-sticky-header-overlay active"></div>
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
