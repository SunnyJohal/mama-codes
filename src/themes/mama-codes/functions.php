<?php
/**
 * Functions File
 * 
 * Loads any child theme specific functionality.
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 * 
 */

 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Set Content Width (in px).
if ( ! isset( $content_width ) ) {
  $content_width = 1170;
}

/**
 * Include Class Files
 *
 * Loads all of the required classes in
 * order for this theme to function.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
require( get_stylesheet_directory() . '/includes/admin/class-tt-admin-login.php' );
require( get_stylesheet_directory() . '/includes/frontend/class-tt-frontend.php' );
require( get_stylesheet_directory() . '/includes/frontend/class-tt-template.php' );
require( get_stylesheet_directory() . '/includes/frontend/class-tt-tribe-events.php' );


/**
 * Setup and Define Theme Support
 *
 * Setup and define the features that
 * this theme supports and loads the
 * language files if required.
 *
 * @since  1.0.0
 * @version 1.0.0
 *
 */
// Admin
add_action( 'after_setup_theme', array( 'TT_Admin_Login', 'get_instance' ) );

// Frontend
add_action( 'after_setup_theme', array( 'TT_Frontend', 'get_instance' ) );
add_action( 'after_setup_theme', array( 'TT_Template', 'get_instance' ) );
add_action( 'after_setup_theme', array( 'TT_Tribe_Events', 'get_instance' ) );

/**
 * Child Theme Specific Changes
 * 
 * Adds any additional customizations that
 * override the parent theme.
 * 
 * @since 1.0.0
 * @version 1.0.0
 */

/**
 * Add Custom Fonts to <head>
 */
add_action('wp_head', function() {
  ?>
  <style>
    @font-face {
      font-family: 'Brandon Grotesque Medium';
      src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/brandon_med-webfont.woff2') format('woff2'),
           url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/brandon_med-webfont.woff') format('woff');
      font-weight: bold;
      font-style: normal;
    }

    @font-face {
      font-family: 'Brandon Grotesque Regular';
      src: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/brandon_reg-webfont.woff2') format('woff2'),
           url('<?php echo get_stylesheet_directory_uri(); ?>/assets/fonts/brandon_reg-webfont.woff') format('woff');
      font-weight: normal;
      font-style: normal;
    }
  </style>
  <?php
}, 10);


/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {

  // Load default font family
  $font_families = array(
    'Roboto:300,300italic,400,400italic,700,700italic',
  );

  $query_args = array(
    'family' => implode( '|', $font_families ),
    'subset' => 'latin,latin-ext',
  );

  $fonts_url = add_query_arg( $query_args, "https://fonts.googleapis.com/css" );

  if ( ! empty( $fonts_url ) ) {
    wp_enqueue_style( 'mama-codes-google-fonts', esc_url_raw( $fonts_url ), array(), null );
  }

  // Load parent theme styles
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

  $manifest = json_decode(file_get_contents('build/assets.json', true));
  $main = $manifest->main;

  // Load generated child theme styles.
  wp_enqueue_style( 'theme-css', get_stylesheet_directory_uri() . "/build/" . $main->css,  false, null );
  wp_enqueue_script( 'theme-js', get_stylesheet_directory_uri() . "/build/" . $main->js, ['jquery'], null, true );

  wp_dequeue_style( 'visualcomposerstarter-fonts' );
}, 100);


add_action('rest_api_init', function () {
    $namespace = 'presspack/v1';
    register_rest_route( $namespace, '/path/(?P<url>.*?)', array(
        'methods'  => 'GET',
        'callback' => 'get_post_for_url',
    ));
});

/**
* This fixes the wordpress rest-api so we can just lookup pages by their full
* path (not just their name). This allows us to use React Router.
*
* @return WP_Error|WP_REST_Response
*/
function get_post_for_url($data) {
  $postId     = url_to_postid($data['url']);
  $postType   = get_post_type($postId);
  $controller = new WP_REST_Posts_Controller($postType);
  $request    = new WP_REST_Request('GET', "/wp/v2/{$postType}s/{$postId}");
  $request->set_url_params(array('id' => $postId));
  return $controller->get_item($request);
}
