<?php
/**
 * Class: TT_Tribe_Events
 *
 * This class is responsible for:
 *     - Overriding any default functionality provided by
 *  		 the events calendar plugin.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */
if ( ! class_exists( 'TT_Tribe_Events' ) ) :
	class TT_Tribe_Events {

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
			add_filter( 'tribe-events-bar-filters',  array( $this, 'remove_search_from_bar' ), 1000, 1 );
			add_filter( 'tribe-events-bar-filters',  array( $this, 'update_geolocation_event_bar_filter' ), 1000, 1 );
		}

		/**
		 * Remove search from bar
		 *
		 * Removes the default keyword search from the
		 * main events filter bar.
		 * 
		 * @param array $filters - An assoc array of current filters.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function remove_search_from_bar( $filters ) {

			// Unset the keyword search.
			if ( isset( $filters['tribe-bar-search'] ) ) {
				unset( $filters['tribe-bar-search'] );
			}

			return $filters;
		}

		/**
		 * Update Geolocation Event Bar Filter
		 *
		 * Updates the placeholder of the geolocation field
		 * in the events bar.
		 * 
		 * @param array $filters - An assoc array of current filters.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function update_geolocation_event_bar_filter( $filters ) {

			if ( tribe_is_map() || ! tribe_get_option( 'hideLocationSearch', false ) ) {
				if ( tribe_get_option( 'tribeDisableTribeBar', false ) == false ) {
					$value = '';
					if ( ! empty( $_REQUEST['tribe-bar-geoloc'] ) ) {
						$value = $_REQUEST['tribe-bar-geoloc'];
					}
	
					$lat = '';
					if ( ! empty( $_REQUEST['tribe-bar-geoloc-lat'] ) ) {
						$lat = $_REQUEST['tribe-bar-geoloc-lat'];
					}
	
					$lng = '';
					if ( ! empty( $_REQUEST['tribe-bar-geoloc-lng'] ) ) {
						$lng = $_REQUEST['tribe-bar-geoloc-lng'];
					}
	
					$filters['tribe-bar-geoloc'] = array(
						'name'    => 'tribe-bar-geoloc',
						'caption' => __( 'Near', 'tribe-events-calendar-pro' ),
						'html'    => '<input type="hidden" name="tribe-bar-geoloc-lat" id="tribe-bar-geoloc-lat" value="' . esc_attr( $lat ) . '" /><input type="hidden" name="tribe-bar-geoloc-lng" id="tribe-bar-geoloc-lng" value="' . esc_attr( $lng ) . '" /><input type="text" name="tribe-bar-geoloc" id="tribe-bar-geoloc" value="' . esc_attr( $value ) . '" placeholder="' . __( 'Postcode', 'tribe-events-calendar-pro' ) . '">',
					);
				}
			}

			return $filters;
		}

	}
endif;
