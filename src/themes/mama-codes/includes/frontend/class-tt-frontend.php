<?php
/**
 * Class: TT_Frontend
 *
 * This class is responsible for:
 *     - Loading translations.
 *     - Defining theme support.
 *     - Enqueing theme scripts and styles.
 *     - Registering navigation areas.
 *     - Registering widget areas.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */
if ( ! class_exists( 'TT_Frontend' ) ) :
	class TT_Frontend {

		/**
		 * Instance of this class.
		 *
		 * @var object
		 * @since 1.0.0
		 *
		 */
		protected static $instance = null;

		/**
		 * Constructor Function
		 *
		 * Initialize the plugin by loading admin scripts &
		 * styles and adding a settings page and menu.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		function __construct() {
			/**
			 * Register actions and filters
			 * used by this class.
			 *
			 */
			$this->register_actions();
			$this->register_filters();
			$this->load_theme_textdomain();
			$this->add_theme_support();
			$this->register_nav_menus();
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return    object    A single instance of this class.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Register Custom Actions
		 *
		 * Register any methods in this class that
		 * is hooked into any actions. The specified
		 * function will only execute when the action
		 * is ran.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function register_actions() {
			add_action( 'init', array( $this, 'remove_head_links' ) );
			add_action( 'wp_footer', array( $this, 'enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		}

		/**
		 * Register Custom Filters
		 *
		 * Register any methods in this class that
		 * hook into any filters.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function register_filters() {
			// add_filter( 'embed_oembed_html', array( $this, 'wrap_embeds' ), 99, 4 );
		}

		/**
		 * Load Text Domain
		 *
		 * Specifies the text domain used throughout the
		 * theme and the folder location of the translation
		 * files, allowing it to become available for
		 * translation.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function load_theme_textdomain() {
			load_theme_textdomain( 'mama-codes', get_template_directory() . '/languages' );
		}

		/**
		 * Load Frontend Theme JavaScript
		 *
		 * Will only load scripts on the frontend part of
		 * the website. Hooks into the wp_enqueue_script action.
		 *
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		public function enqueue_scripts() {
		}


		/**
		 * Load Frontend Theme Styles
		 *
		 * Load CSS on the frontend part of the website.
		 * Hooks into the wp_enqueue_script action.
		 *
		 * @todo Add in the ability to have skins and
		 *     deregister the old style
		 *
		 * @todo Look at why we are loading in a
		 *     separate stylesheet
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		public function enqueue_styles() {

		}


		/**
		 * Register Theme Support
		 *
		 * Defines all of the features that this theme
		 * supports with WordPress.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function add_theme_support() {

			/*
			 * Switch default core markup for search
			 * form, comment form, and comments to
			 * output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			) );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that
			 * this theme does not use a hard-coded
			 * <title> tag in the document head, and
			 * expect WordPress to provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			// Adds RSS feed links to <head> for posts and comments.
			add_theme_support( 'automatic-feed-links' );

			// Soil plugin
			add_theme_support('soil-clean-up');
			add_theme_support('soil-jquery-cdn');
			add_theme_support('soil-nav-walker');
			add_theme_support('soil-nice-search');
			add_theme_support('soil-relative-urls');
		}

		/**
		 * Register Navigation Menus
		 *
		 * Register all of the navigation menus
		 * that are used in this theme.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function register_nav_menus() {
			register_nav_menus([
        'primary_logged_in' => __( 'Primary Menu for Logged in Users', 'mama-codes' ),
    	]);
		}

		/**
		 * Register Widget Areas
		 *
		 * Declare all widget areas that are available
		 * for this theme.
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		public function register_widget_areas() {
		}

		/**
		 * Remove Head Links
		 *
		 * This function removes any Wordpress
		 * Version information for security
		 * reasons (i.e. to minimise exploits
		 * via security through obscurity).
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		public function remove_head_links() {
			remove_action( 'wp_head', 'rsd_link') ;
			remove_action( 'wp_head', 'wp_generator' );
			remove_action( 'wp_head', 'feed_links', 2 );
			remove_action( 'wp_head', 'feed_links_extra', 3 );
			remove_action( 'wp_head', 'index_rel_link' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
			remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
			remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		}

		/**
		 * Get Search Title
		 *
		 * Gets the title text if the user is
		 * currently on the search page.
		 *
		 * @return string - The search page title text.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function get_search_title() {
			if ( have_posts() ) {
				return sprintf( __( 'Search Results for: %s', 'titanium-themes' ), esc_attr( get_search_query() ) );
			} else {
				return __( 'Search Results', 'titanium-themes' );
			}
		}

		/**
		 * Wrap oEmbeds
		 *
		 * Function that wraps the default
		 * oEmbed object. This enables the
		 * ability to override the
		 * $content_width attribute in
		 * using a CSS selector.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function wrap_embeds( $html, $url, $attr, $post_id ) {
			return "<div class='embed-responsive embed-responsive-16by9 vf-embed'>{$html}</div>";
		}

		/**
		 * Get Context
		 *
		 * Returns the appropriate context
		 * depending on where the user is
		 * on the site.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function get_context() {

			// Default context.
			$context = 'index';

			// Determine context.
			if ( is_front_page() ) {
				// Front Page
				$context = 'front-page';
			} else if ( is_date() ) {
				// Date Archive Index
				$context = 'date';
			} else if ( is_author() ) {
				// Author Archive Index
				$context = 'author';
			} else if ( is_category() ) {
				// Category Archive Index
				$context = 'category';
			} else if ( is_tag() ) {
				// Tag Archive Index
				$context = 'tag';
			} else if ( is_tax() ) {
				// Taxonomy Archive Index
				$context = 'taxonomy';
			} else if ( is_archive() ) {
				// Archive Index
				$context = 'archive';
			} else if ( is_search() ) {
				// Search Results Page
				$context = 'search';
			} else if ( is_404() ) {
				// Error 404 Page
				$context = '404';
			} else if ( is_attachment() ) {
				// Attachment Page
				$context = 'attachment';
			} else if ( is_singular( 'post' ) ) {
				// Single Blog Post
				$context = 'single';
			} else if ( is_page() ) {
				// Static Page
				$context = 'page';
			} else if ( is_singular() ) {
				// Single Custom Post
				$context = get_post_type();
			} else if ( is_home() ) {
				// Blog Posts Index
				$context = 'home';
			}

			// Return the context.
			return apply_filters( 'titanium_get_context', $context );
		}

	}
endif;
