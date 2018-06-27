<?php
/**
 * Class: Mama_Testimonials
 *
 * This file initialises the testimonial
 * functionality for this plugin.
 *
 * @package     diamond_branches
 * @author      Sunny Johal - Titanium Themes <support@titaniumthemes.com>
 * @copyright   Copyright (c) 2016, Titanium Themes
 * @version     1.0.0
 *
 */
if ( ! class_exists( 'Mama_Testimonials' ) ) :
	class Mama_Testimonials {
		/**
		 * Instance of this class.
		 *
		 * @var      object
		 * @since    1.0
		 *
		 */
		protected static $instance = null;


		/**
		 * Constructor Function
		 *
		 * Initialize the class and register all
		 * actions and filters.
		 *
		 * @since 1.0
		 * @version 1.0
		 *
		 */
		function __construct() {
			$this->plugin_slug = 'mama-codes';
			$this->register_actions();
			$this->register_filters();
			$this->register_shortcodes();
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return    object    A single instance of this class.
		 *
		 * @since 1.0
		 * @version 1.0
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
		 * Add any custom actions in this function.
		 *
		 * @since 1.0
		 * @version 1.0
		 *
		 */
		public function register_actions() {
			add_action( 'init', array( $this, 'register_posttypes' ) );
			add_action( 'init', array( $this, 'register_taxonomies' ) );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
			add_action( 'save_post', array( $this, 'save_testimonial_data' ) );
			add_action( 'visualcomposerstarter_hook_before_footer', array( $this, 'load_testimonial_above_footer' ) );
		}

		/**
		 * Register Custom Filters
		 *
		 * Add any custom filters in this function.
		 *
		 * @since 1.0
		 * @version 1.0
		 *
		 */
		public function register_filters() {
		}

		/**
		 * Register Shortcodes
		 *
		 * Add any frontend shortcode handles here.
		 *
		 * @since 1.0
		 * @version 1.0
		 *
		 */
		public function register_shortcodes() {
		}

		/**
		 * Register Posttypes
		 *
		 * Register the testimonial posttype internally. This
		 * will be used to store any testimonial instances.
		 * Created when the 'init' action is fired.
		 *
		 * Menu Position: 'menu_position' => 5
		 *
		 * Menu Position Reference:
		 *
		 * 0   - Above Everything
		 * 5   - Below Posts
		 * 10  - Below Media
		 * 15  - Below Links
		 * 20  - Below Pages
		 * 25  - Below Comments
		 * 60  - Below First Separator
		 * 65  - Below Plugins
		 * 70  - Below Users
		 * 75  - Below Tools
		 * 80  - Below Settings
		 * 100 - Below Second Separator
		 *
		 * Custom Filters:
		 *     - etb_testimonial_posttype_name
		 *     - etb_testimonial_posttype_singular_name
		 *     - etb_testimonial_posttype_menu_name
		 *
		 *
		 * @link 	http://codex.wordpress.org/Function_Reference/register_post_type 	register_post_type()
		 *
		 * @since 1.0
		 * @version 1.0
		 *
		 */
		public function register_posttypes() {

			// Register posttype
			register_post_type( 'mama_testimonial', array(
				'labels'           => array(
					'name'               => __( 'Testimonials', 'mama-codes' ),
					'singular_name'      => __( 'Testimonial', 'mama-codes' ),
					'all_items'          => __( 'All Testimonials', 'mama-codes' ),
					'add_new'            => __( 'Add A New Testimonial', 'mama-codes' ),
					'add_new_item'       => __( 'Add A New Testimonial', 'mama-codes' ),
					'edit_item'          => __( 'Edit This Testimonial', 'mama-codes' ),
					'new_item'           => __( 'New Testimonial', 'mama-codes' ),
					'view_item'          => __( 'View Testimonial', 'mama-codes' ),
					'search_items'       => __( 'Search Testimonials', 'mama-codes' ),
					'not_found'          => __( 'No Testimonials Found', 'mama-codes' ),
					'not_found_in_trash' => __( 'No Testimonials Found in Trash', 'mama-codes' ),
					'parent_item_colon'  => '',
				),
				'description'         => __( 'Stores and displays testimonials used in the theme.', 'mama-codes' ),
				'public'              => true,
				'hierarchical'        => false,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'testimonials' ),
				'delete_with_user'    => false,
				'menu_position'       => 25,
				'menu_icon'           => 'dashicons-format-chat',
				'supports'            => array( 'title', 'editor', 'thumbnail', ),
				'exclude_from_search' => true,
				'page_attributes'     => true,
			) );
		}

		/**
		 * Register Taxonomies
		 *
		 * Setup the swatch taxonomies and define the default labels
		 * to use in the WordPress admin area. The purpose of creating
		 * taxonomies for this posttype is to allow the user to assign
		 * swatches to products.
		 *
		 * Custom Filters:
		 *     - etb_testimonial_category_tax_name
		 *
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy 	register_taxonomy()
		 * @link http://codex.wordpress.org/Function_Reference/add_action 			add_action()
		 *
		 * @since  1.0
		 * @version 1.0
		 *
		 */
		public function register_taxonomies() {

			$args = array(
				'labels'       => array(
					'name'              => _x( 'Testimonial Categories', 'Taxonomy general name', 'mama-codes' ),
					'singular_name'     => _x( 'Testimonial Category', 'Taxonomy general name', 'mama-codes' ),
					'menu_name'         => _x( 'Categories', 'Taxonomy menu name', 'mama-codes' ),
					'search_items'      => __( 'Search Categories', 'mama-codes' ),
					'all_items'         => __( 'All Categories', 'mama-codes' ),
					'most_used_items'   => null,
					'parent_item'       => null,
					'parent_item_colon' => null,
					'edit_item'         => __( 'Edit Category', 'mama-codes' ),
					'update_item'       => __( 'Update Category', 'mama-codes' ),
					'add_new_item'      => __( 'Add New Category', 'mama-codes' ),
					'new_item_name'     => __( 'New Category', 'mama-codes' ),
				),
				'hierarchical' => true,
				'show_ui'      => true,
				'query_var'    => true,
				'has_archive'  => true,
			);

			register_taxonomy( 'mama_testimonial_category', array( 'mama_testimonial' ), $args );
		}

		/**
		 * Add Metaboxes
		 *
		 * Adds metaboxes for each individual
		 * screen. Allows the admin user to
		 * list testimonials if required
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function add_meta_boxes() {
			// Branch Address
			add_meta_box(
				'mama-testimonial',
				'Page Testimonial',
				array( $this, 'get_testimonial_metabox' ),
				array( 'page', 'diamond_branches' ),
				'side',
				'default'
			);
		}

		/**
		 * Testimonial Metabox
		 *
		 * Inserts the testimonial metabox.
		 *
		 * @return [type] [description]
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		public function get_testimonial_metabox( $post ) {
			// Get the post metas
			$cat_value       = get_post_meta( $post->ID, '_mama_testimonial_category_id', true );
			$headline        = get_post_meta( $post->ID, '_mama_testimonial_headline', true );
			$interval        = get_post_meta( $post->ID, '_mama_testimonial_interval', true );
			$show_thumbnails = get_post_meta( $post->ID, '_mama_testimonial_show_thumbnails', true );
			$hide_author     = get_post_meta( $post->ID, '_mama_testimonial_hide_author', true );
			$background      = get_post_meta( $post->ID, '_mama_testimonial_background', true );

			// Output security nonce.
			wp_nonce_field( 'mama_testimonial', 'mama_testimonial_nonce' );

			//Define $args for wp_dropdown_categories()
			$args = array(
				'show_option_all'    => '',
				'show_option_none'   => __( 'Hide Testimonials on this page', 'mama-codes' ),
				'orderby'            => 'name',
				'order'              => 'ASC',
				'show_count'         => 1,
				'hide_empty'         => 1,
				'child_of'           => 0,
				'exclude'            => '',
				'echo'               => 1,
				'selected'           => $cat_value,
				'hierarchical'       => 0,
				'name'               => 'mama-testimonial-category',
				'id'                 => 'mama-testimonial-category',
				'class'              => 'widefat',
				'tab_index'          => 0,
				'taxonomy'           => 'mama_testimonial_category',
				'hide_if_empty'      => false
			);

			?>
			<p class="howto">If you wish to display a testimonial on this page please fill out the details below.</p>

			<!-- Category -->
			<p>
				<label for="mama-testimonial-category" style="margin-bottom: 6px; display:block;"><b>Testimonial Category</b></label>
				<?php wp_dropdown_categories( $args ); ?>
			</p>

			<!-- Headline -->
			<p>
				<label for="mama-testimonial-headline" style="margin-bottom: 6px; display:block;"><b>Headline</b></label>
				<input name="mama-testimonial-headline" id="mama-testimonial-headline" class="widefat" type="text" value="<?php echo $headline; ?>" />
			</p>

			<!-- Interval Transition -->
			<p>
				<label for="mama-testimonial-interval" style="margin-bottom: 6px; display:block;"><b>Transition Speed</b></label>
				<input type="number" min="1" id="mama-testimonial-interval" name="mama-testimonial-interval" value="<?php echo $interval; ?>" style="width:100%;" class="widefat">
				<span class="howto"><?php _e( 'Testimonial transition speed, in seconds.', 'mama-codes' ); ?></span>
			</p>

			<p>
				<label for="mama-testimonial-background" style="margin-bottom: 6px; display:block;"><b>Background Color</b></label>
				<select name="mama-testimonial-background" id="mama-testimonial-background" class="widefat">
					<option value="white" <?php selected( 'white', $background ); ?>>White</option>
					<option value="black" <?php selected( 'black', $background ); ?>>Black</option>
					<option value="dark-grey" <?php selected( 'dark-grey', $background ); ?>>Dark Grey</option>
					<option value="pink" <?php selected( 'pink', $background ); ?>>Diamond Pink</option>
					<option value="blue" <?php selected( 'blue', $background ); ?>>Diamond Blue</option>
					<option value="green" <?php selected( 'green', $background ); ?>>Diamond Green</option>
				</select>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_thumbnails ); ?> id="mama-testimonial-thumbnails" name="mama-testimonial-thumbnails" />
				<label for="mama-testimonial-thumbnails"><?php _e( 'Display thumbnails', 'mama-codes' ); ?></label><br />


				<input class="checkbox" type="checkbox" <?php checked( $hide_author ); ?> id="mama-testimonial-hide-author" name="mama-testimonial-hide-author" />
				<label for="mama-testimonial-hide-author"><?php _e( 'Hide author', 'mama-codes' ); ?></label><br />
			</p>
			<?php
		}

		/**
		 * Save Testimonial Data
		 *
		 * Runs when the user saves a page/post/branch
		 * and updates the meta values for each item.
		 *
		 * @param  int $post_id - ID of the post being saved
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function save_testimonial_data( $post_id ) {
			// Exit if not authorised or autosaving post
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ||
				 ! current_user_can( 'edit_theme_options' ) ) {
				return $post_id;
			}


			/**
			 * We need to verify this came from the
			 * our screen and with proper authorization,
			 * because save_post can be triggered at
			 * other times.
			 *
			 */
			if ( ! isset( $_POST['mama_testimonial_nonce'] ) ) {
				return $post_id;
			}

			$nonce = $_POST['mama_testimonial_nonce'];

			// Check if nonce is valid
			if ( ! wp_verify_nonce( $nonce, 'mama_testimonial' ) ) {
				return $post_id;
			}

			// Nonce valid, so save data.

			// Testimonial fields
			$cat_value       = isset( $_POST['mama-testimonial-category'] ) ? esc_attr( $_POST['mama-testimonial-category'] ) : '';
			$headline        = isset( $_POST['mama-testimonial-headline'] ) ? esc_attr( $_POST['mama-testimonial-headline'] ) : '';
			$interval        = isset( $_POST['mama-testimonial-interval'] ) ? esc_attr( $_POST['mama-testimonial-interval'] ) : 5;
			$show_thumbnails = isset( $_POST['mama-testimonial-thumbnails'] ) ? true : false;
			$hide_author     = isset( $_POST['mama-testimonial-hide-author'] ) ? true : false;
			$background      = isset( $_POST['mama-testimonial-background'] ) ? esc_attr( $_POST['mama-testimonial-background'] ) : '';

			// // Update the post meta
			update_post_meta( $post_id, '_mama_testimonial_category_id', $cat_value );
			update_post_meta( $post_id, '_mama_testimonial_headline', $headline );
			update_post_meta( $post_id, '_mama_testimonial_interval', $interval );
			update_post_meta( $post_id, '_mama_testimonial_show_thumbnails', $show_thumbnails );
			update_post_meta( $post_id, '_mama_testimonial_hide_author', $hide_author );
			update_post_meta( $post_id, '_mama_testimonial_background', $background );
		}

		/**
		 * Load Testimonial
		 *
		 * Loads the testimonial
		 *
		 * @return [type] [description]
		 *
		 * @since  1.0.0
		 * @version 1.0.0
		 *
		 */
		function load_testimonial_above_footer() {
			$cat_value = get_post_meta( get_the_ID(), '_mama_testimonial_category_id', true );

			if ( $cat_value && -1 != $cat_value ) {
				get_template_part( 'template-parts/testimonials' );
			}
		}
	}
endif;
