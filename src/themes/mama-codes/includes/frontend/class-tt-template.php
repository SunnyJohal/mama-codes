<?php
/**
 * Class: TT_Template
 *
 * This class is responsible for:
 *     - Overriding default filters.
 *     - Defining useful template tags.
 * 
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */
if ( ! class_exists( 'TT_Template' ) ) :
	class TT_Template {

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

			// Initialize template classes.
			add_filter( 'titanium_html_classes', array( $this, 'add_html_classes' ), 10, 1 );
			add_filter( 'body_class', array( $this, 'add_body_classes' ), 10, 1 );

			// Default WordPress filter overrides.
			add_filter( 'get_the_archive_title', array( $this, 'remove_archive_title_prefix' ), 10, 1 );
			add_filter( 'img_caption_shortcode', array( $this, 'img_caption_shortcode' ), 10, 3 );
		}

		/**
		 * Add HTML Classes
		 *
		 * Adds custom classes to the <html>
		 * element.
		 *
		 * @param array $classes  - Current array of classes.
		 * @return array $classes - Updated array of classes.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function add_html_classes( $classes ) {
			$classes[] = is_admin_bar_showing() ? 'admin-bar' : '';
			return $classes;
		}

		/**
		 * Add Body Classes
		 *
		 * Adds custom classes to the <body>
		 * element.
		 *
		 * @param array $classes  - Current array of classes.
		 * @return array $classes - Updated array of classes.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function add_body_classes( $classes ) {
			global $post;
			if ( is_home() ) {
				$key = array_search( 'blog', $classes );
				if ( $key > -1 ) {
					unset( $classes[ $key ] );
				}
			} elseif ( is_page() ) {
				$classes[] = sanitize_html_class( $post->post_name );
			} elseif ( is_singular() ) {
				$classes[] = sanitize_html_class( $post->post_name );
			}
			return $classes;
		}

		/**
		 * Get the Title
		 *
		 * Returns the title for the current
		 * page.
		 *
		 * @return string - Current page title.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function get_the_title() {

			$title = "";
			if ( is_home() && 'posts' == get_option( 'show_on_front' ) ) {
				$title = bloginfo( 'description' );
			} else if ( is_singular() ) {
				$title = get_the_title();
			} else if ( is_404() ) {
				$title =  _x( 'Not Found', 'Title for the 404 page.', 'titanium-themes' );
			} else if ( is_search() ) {
				$title = $this->get_search_title();
			} else if ( is_post_type_archive( 'tribe_events' ) ) {
				$title = tribe_get_events_title();
			} else {
				$title = get_the_archive_title();
			}

			return apply_filters( 'titanium_title', $title );
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
		 * Remove Archive Title Prefix
		 *
		 * Removes the title prefix for category
		 * and post type archive pages.
		 *
		 * @return string - Current page title.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function remove_archive_title_prefix( $title ) {

			// Redefine certain archive titles.
			if ( is_category() ) {
				$title = single_cat_title( '', false );
			} elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			}

			return $title;
		}

		/**
		 * Filter Default Caption Output
		 *
		 * @param string $output  The caption output. Default empty.
		 * @param array  $attr    Attributes of the caption shortcode.
		 * @param string $content The image element, possibly wrapped in a hyperlink.
		 * @return string $output  The caption output.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function img_caption_shortcode( $output, $attr, $content ) {

			$atts = shortcode_atts( array(
				'id'	  => '',
				'align'	  => 'alignnone',
				'width'	  => '',
				'caption' => '',
				'class'   => '',
			), $attr, 'caption' );

			$atts['width'] = (int) $atts['width'];

			if ( $atts['width'] < 1 || empty( $atts['caption'] ) ) {
				return $content;
			}

			if ( ! empty( $atts['id'] ) ) {
				$atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';
			}

			$class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

			return '<figure ' . $atts['id'] . 'style="max-width: ' . (int) $atts['width'] . 'px;" class="' . esc_attr( $class ) . '">'
			. do_shortcode( $content ) . '<figcaption class="wp-caption-text mdl-typography--caption">' . $atts['caption'] . '</figcaption></figure>';
		}

		/**
		 * Output Breadcrumbs
		 *
		 * Displays breadcrumbs to help the user
		 * navigate the website. Also has built in
		 * support for:
		 *     - WooCommerce Breadcrumbs
		 *
		 * Custom Filters:
		 *     - titanium_breadcrumb_container_before
		 *     - titanium_breadcrumb_container_after
		 *     - titanium_breadcrumb_container_open
		 *     - titanium_breadcrumb_container_close
		 *     - titanium_breadcrumb_delimiter
		 *     - titanium_breadcrumb_home_text
		 *     - titanium_breadcrumb_blog_text
		 *     - titanium_breadcrumb_current_before
		 *     - titanium_breadcrumb_current_after
		 *     - titanium_breadcrumb
		 *
		 * @todo Check if yoast_breadcrumbs exist
		 *
		 * @global object $post
		 * @global object $wp_query
		 *
		 * @return string - Breadcrumb output
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function get_breadcrumbs() {

			// Bail if we are on the front page.
			// if ( is_front_page() ) {
			// 	return;
			// }

			// Bail and load WooCommerce Breadcrumbs if we are in WooCommerce
			if ( function_exists( 'woocommerce_breadcrumb' ) && is_woocommerce() ) {
				woocommerce_breadcrumb();
				return;
			}

			// Get global post object.
			global $post;

			/**
			 * Breadcrumb Filters:
			 *
			 * Allow developers to book into the
			 * breadcrumb elements via filters.
			 *
			 */
			$container_before      = apply_filters( 'titanium_breadcrumb_container_before', '' );
			$container_after       = apply_filters( 'titanium_breadcrumb_container_after', '' );
			$container_crumb       = apply_filters( 'titanium_breadcrumb_container_open', '<ol class="breadcrumb">' );
			$container_crumb_end   = apply_filters( 'titanium_breadcrumb_container_close', '</ol><div class="clearfix"></div>' );
			$delimiter             = apply_filters( 'titanium_breadcrumb_delimiter', '' );
			$name                  = apply_filters( 'titanium_breadcrumb_home_text', _x( 'Home', 'Home link text for the theme breadcrumbs.', 'titanium-themes' ) );
			$blog_name             = apply_filters( 'titanium_breadcrumb_blog_text', _x( 'Blog', 'Blog link text for the theme breadcrumbs.', 'titanium-themes' ) );
			$current_before        = apply_filters( 'titanium_breadcrumb_current_before', '<li class="active">' );
			$current_after         = apply_filters( 'titanium_breadcrumb_current_after', '</li>' );
			$base_link             = '';
			$hierarchy             = '';
			$current_location      = '';
			$current_location_link = '';
			$crumb_pagination      = '';
			$home                  = did_action( 'my_diamond_template' ) ? site_url( 'my-diamond/home' ) : home_url('/');

			// Change name for my diamond.
			$name = did_action( 'my_diamond_template' ) ? 'My Diamond' : $name;

			// Build the base link.
			$base_link = is_front_page() ? "<strong>{$name}</strong>" : "<li><a href='{$home}'>{$name}</a></li>";

			/**
			 * If static page as front page,
			 * and on blog posts index.
			 */
			if ( is_home() && ( 'page' == get_option( 'show_on_front' ) ) ) {
				$hierarchy       = $delimiter;
				$current_location = $blog_name;
			}

			/*
			 * Define taxonomy breadcrumbs for
			 * custom post types.
			 */
			if ( is_singular( get_post_type() ) &&
				 ! is_singular( 'post' )        &&
				 ! is_page()                    &&
				 ! is_attachment() ) {

				// Get current post object.
				global $post;
				$post_type_object = get_post_type_object( get_post_type() );
				$post_type_name   = $post_type_object->labels->name;
				$post_type_slug   = $post_type_object->name;
				$taxonomies       = get_object_taxonomies( get_post_type() );
				$taxonomy         = ( ! empty( $taxonomies ) ? $taxonomies[0] : false );
				$terms            = ( $taxonomy ? get_the_term_list( $post->ID, $taxonomy, '<li>', '<span style="padding: 0 5px;">/</span>', '</li>' ) : false );
				$hierarchy        = $delimiter . '<li><a href="' . get_post_type_archive_link( $post_type_slug ) . '">' . $post_type_name . '</a></li>';

				// Remove terms for single sales leads.
				if ( is_singular( 'diamond_leads' ) || is_singular( 'md_tasks' ) ) {
					$terms = false;
				}

				$hierarchy        .= ( $terms ? $delimiter . $terms . $delimiter : $delimiter );
				$current_location  = get_the_title();

			}

			/*
			 * Define category hierarchy breadrumbs
			 * for category archives.
			 */
			elseif ( is_category() ) {

				// Get current WP_Query object.
				global $wp_query;
				$cat_obj    = $wp_query->get_queried_object();
				$this_cat   = $cat_obj->term_id;
				$this_cat   = get_category( $this_cat );
				$parent_cat = get_category( $this_cat->parent );

				if ( $this_cat->parent != 0 ) {

					// Get parents
					$parents = get_category_parents( $parent_cat, true, $delimiter );
					$parents = str_replace( '<a', '<li><a', $parents );
					$parents = str_replace( '</a>', '</a></li>', $parents );

					$hierarchy = ( $delimiter . __( '', 'titanium-themes' ) . $parents ) ;
				} else {
					$hierarchy = $delimiter . __( '', 'titanium-themes' );
				}

				$current_location = single_cat_title( '' , false );
			}

			/*
			 * Define current location for
			 * custom taxonomy archives.
			 */
			elseif ( is_tax() ) {

				// Get current WP_Query object.
				global $wp_query;

				$post_type_object = get_post_type_object( get_post_type() );
				$tax_link         = '#';
				$post_type_name   = '';

				if ( $post_type_object ) {
					$post_type_name = $post_type_object->labels->name;
					$post_type_slug = $post_type_object->name;
					$tax_link       = get_post_type_archive_link( $post_type_slug );
				}

				if ( is_tax( 'book_of_diamond_categories' ) || is_tax( 'book_of_diamond_tags' ) ) {
					$post_type_name = 'Book of Diamond';
					$tax_link = site_url( 'book-of-diamond' );
				}

				$custom_tax         = $wp_query->query_vars['taxonomy'];
				$custom_tax_object  = get_taxonomy( $custom_tax );
				$hierarchy          = $delimiter . '<li><a href="' . $tax_link . '">' . $post_type_name . '</a></li>';
				$hierarchy         .= $delimiter . ' ';
				$current_location   = single_term_title( '', false );
			}


			/*
			 * Define current location for
			 * parent pages.
			 */
			elseif ( is_page()         &&
				     ! is_front_page() &&
				     ! $post->post_parent ) {

				// Note: get_the_title() is filtered to output a
				// default title if none is specified
				$hierarchy        = $delimiter;
				$current_location = get_the_title();
			}

			/*
			 * Define parent page hierarchy
			 * breadrumbs for child pages.
			 */
			elseif ( ! is_front_page() &&
					 is_page()         &&
					 $post->post_parent ) {

				// Get parent id
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();

				// Get all parents and add to array.
				while ( $parent_id ) {
					$page          = get_page( $parent_id );
					$breadcrumbs[] = '<li><a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>';
					$parent_id     = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );

				foreach ( $breadcrumbs as $crumb ) {
					$hierarchy .= $delimiter . $crumb;
				}

				// Note: get_the_title() is filtered to output a
				// default title if none is specified
				$hierarchy        = $hierarchy . $delimiter;
				$current_location = get_the_title();
			}

			/*
			 * Define breadcrumbs if we are
			 * displaying search results.
			 */
			elseif ( is_search() ) {
				$hierarchy        = $delimiter . ' ';
				$current_location = sprintf( _x( 'Search Results for: %s', 'Breadcrumb prefix for the search result page.', 'titanium-themes' ), get_search_query() );
			}

			/*
			 * Define breadcrumbs if we are
			 * displaying a 404 error page.
			 */
			elseif ( is_404() ) {
				$hierarchy        = $delimiter . ' ';
				$current_location = __( '404: Page Not Found', 'titanium-themes' );
			}

			/*
			 * Define breadrumbs for day/year/month
			 * date-based archives.
			 */
			elseif ( is_date() ) {

				// Define Year/Month Hierarchy Crumbs for Day Archive
				if  ( is_day() ) {
					$date_string       = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ' . $delimiter . ' ' . '<a href="' . get_month_link( get_the_time( 'Y' ),get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a> ';
					$date_string      .= $delimiter . ' ';
					$current_location  = get_the_time( 'd' );
				}

				// Define Year Hierarchy Crumb for Month Archive
				elseif ( is_month() ) {
					$date_string      = '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a> ';
					$date_string     .= $delimiter . ' ';
					$current_location = get_the_time( 'F' );
				}

				// Set Current Location for Year Archive
				elseif ( is_year() ) {
					$date_string      = '';
					$current_location = get_the_time( 'Y' );
				}

				$hierarchy = $delimiter . sprintf( _x( 'Posts Published in: %s', 'Breadcrumb prefix for date based archives.', 'titanium-themes' ), $date_string );
			}

			/*
			 * Define category hierarchy breadcrumbs
			 * for single posts.
			 */
			elseif ( is_singular( 'post' ) ) {
				$cats = get_the_category();

				// Assume the first category is current
				$current_cat = ( $cats ? $cats[0] : '' );

				// Determine if category is hierarchical
				$cat_is_hierarchical = false;

				foreach ( $cats as $cat ) {
					if ( '0' != $cat->parent ) {
						$cat_is_hierarchical = true;
						break;
					}
				}

				// If category is hierarchical, ensure we have the correct child category
				if ( $cat_is_hierarchical ) {
					foreach ( $cats as $cat ) {
						$children = get_categories( array( 'parent' => $cat->term_id ) );
						if ( 0 == count( $children ) ) {
							$current_cat = $cat;
							break;
						}
					}
				}
				// Get the hierarchical list of category links
				$hierarchy = $delimiter . '<li>' . get_category_parents( $current_cat, true, $delimiter ) . '</li>';

				// Note: get_the_title() is filtered to output a default title if none is specified
				$current_location = get_the_title();

			}

			/*
			 * Define category and parent post
			 * breadcrumbs for post attachments.
			 */
			elseif ( is_attachment() ) {
				$parent      = get_post( $post->post_parent );
				$cat_parents = '';

				if ( get_the_category( $parent->ID ) ) {
					$cat         = get_the_category( $parent->ID );
					$cat         = $cat[0];
					$cat_parents = get_category_parents( $cat, true, $delimiter );
				}
				$hierarchy        = $delimiter . $cat_parents . '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a> ' . $delimiter;
				$current_location = get_the_title();
			}

			/*
			 * Define the current location for
			 * custom post type archives.
			 */
			elseif ( is_post_type_archive( get_post_type() ) ) {
				$hierarchy        = $delimiter . ' ';
				$post_type_object = get_post_type_object( get_post_type() );

				if ( $post_type_object ) {
					$post_type_name   = $post_type_object->labels->name;
					$current_location = $post_type_name;
				}

				// My Diamond Specific Archive Pages
				if ( is_post_type_archive( 'diamond_leads' ) ) {

					if ( isset( $_GET['type'] ) && 'new' === $_GET['type'] ) {
						$hierarchy = $delimiter . '<li><a href="' . site_url( 'my-diamond/leads/' ) . '">Leads</a></li>' . $delimiter;
					}
				}

			}

			// Define pagination for paged archive pages.
			if ( get_query_var( 'paged' ) && ! function_exists( 'wp_paginate' ) ) {
				$current_location .= sprintf( _x( ' (Page %s)', 'Breadcrumb suffix for paged archive pages.', 'titanium-themes' ), get_query_var( 'paged' ) );
			}

			// Define pagination for paged posts and pages.
			if ( get_query_var( 'page' ) ) {
				$crumb_pagination = sprintf( _x( ' Page %s ', 'Breadcrumb suffix for paged posts and pages.', 'titanium-themes' ), get_query_var( 'page' ) );
			}

			// Build the current location link markup.
			$current_location_link = "{$current_before}{$current_location}{$current_after}";
			$current_location_link = "";

			// Build the resulting breadcrumbs.
			$breadcrumb = "{$container_before}{$container_crumb}{$base_link}{$hierarchy}{$current_location_link}{$crumb_pagination}{$container_crumb_end}{$container_after}";

			// Output the result
			echo apply_filters( 'titanium_breadcrumb',
				$breadcrumb,
				$container_before,
				$container_after,
				$container_crumb,
				$container_crumb_end,
				$delimiter,
				$name,
				$blog_name,
				$current_before,
				$current_after
			);
		}

	}
endif;
