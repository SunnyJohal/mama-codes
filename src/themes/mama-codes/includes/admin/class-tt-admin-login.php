<?php
/**
 * Class: TT_Admin_Login
 *
 * Custom admin and login screen customizations for 
 * Mama codes.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */
if ( ! class_exists( 'TT_Admin_Login' ) ) :
	class TT_Admin_Login {

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
			add_action( 'login_enqueue_scripts', array( $this, 'output_custom_login_screen_styles' ), 1000 );
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
			add_filter( 'login_redirect', array( $this, 'login_redirect' ), 10, 3 );
			add_filter( 'login_headerurl', array( $this, 'login_headerurl' ) );
		}

		/**
		 * Output Login Screen Styles
		 *
		 * Outputs custom css in the document <head />
		 * to customize the appearance of the login
		 * screen.
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 *
		 */
		public function output_custom_login_screen_styles() {
			?>
			<style type="text/css">
				/* Background Styles */
				body.login {
					background: #288fd2 url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mama-codes-hero-illustration.png) bottom;
					background-size: contain;
					background-repeat: repeat-x;
					background-attachment: fixed;
				}

				/* Login Form Styles */
				.login form {
					padding-bottom: 26px!important;
				}

				/* Logo Styles */
				body.login div#login h1 a {
					width: 200px;
					height: 50.5px;
					background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/mama-codes-logo-white.png);
					background-size: 200px 50.5px;
					padding-bottom: 0;
					margin-bottom: 0;
				}

				/* Input styles */
				.login label {
					font-size: 12px !important;
				}

				input[type=text],
				input[type=search],
				input[type=radio],
				input[type=tel],
				input[type=time],
				input[type=url],
				input[type=week],
				input[type=password],
				input[type=checkbox],
				input[type=color],
				input[type=date],
				input[type=datetime],
				input[type=datetime-local],
				input[type=email],
				input[type=month],
				input[type=number],
				select,
				textarea {
					box-shadow: none !important;
				}

				/* Login Button Styles */
				.wp-core-ui .button-primary {
					text-shadow: none !important;
					border-radius: 1px !important;
					box-shadow: none !important;
					border-color: #66d264 !important;
					background: #66d264 !important;
				}

				.wp-core-ui .button-primary:hover {
					border-color: #47c944 !important;
					background: #47c944 !important;	
				}

				/* Link styles */
				.login #nav,
				.login #backtoblog {
					padding: 0 !important;
				}

				.login #backtoblog a,
				.login #nav a {
					background: #6abcc5;
					color: rgba( 255, 255, 255, 0.87 ) !important;
					display: block;
					padding: 10px;
					text-align: center;
					border-radius: 1px;
					box-shadow: 0 1px 3px rgba(0,0,0,.13);
				}

				.login #backtoblog a:hover,
				.login #nav a:hover {
					background: #288fd2
				}

				a.privacy-policy-link {
					display: none;
				}
			</style>
			<?php
		}

		/**
		 * Redirect Users on Login Filter
		 *
		 * A filter to allow developers to redirect users
		 * to a custom location (e.g. redirect subscribers
		 * to the frontend of the website after login).
		 *
		 * Codex functions used:
		 * {@link http://codex.wordpress.org/Function_Reference/add_filter}    				add_filter()
		 * {@link http://codex.wordpress.org/Plugin_API/Filter_Reference/login_redirect}	Login redirect filter
		 * 
		 * @param  string $redirect_to 	the URL to redirect to
		 * @param  string $request     	the URL the user is coming from
		 * @param  object $user        	an object containing the logged in user's data
		 * 
		 * @return string $redirect_to  The new url to redirect the user to
		 * 
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function login_redirect( $redirect_to, $request, $user ) {
			return $redirect_to;
		}

		/**
		 * Change Logo Link On Admin Login Page
		 *
		 * Hooks into the 'login_headerurl' filter to allow
		 * a custom admin logo href attribute on the login page.
		 *
		 * Codex functions used:
		 * {@link http://codex.wordpress.org/Function_Reference/esc_url}             esc_url()
		 * {@link http://codex.wordpress.org/Function_Reference/add_filter}          add_filter()
		 *
		 * @param string $login_header_url   logo login url
		 *
		 * @since 1.0
		 * @version 1.0
		 * 
		 */
		public function login_headerurl( $login_header_url ) {
			return site_url();
		}
	}
endif;
