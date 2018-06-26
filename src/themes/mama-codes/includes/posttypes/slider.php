<?php
/**
 * Slider Custom Posttype:
 * 
 * Defines a custom posttype to allow the user to create
 * slides and organise them into categories. This posttype
 * will be used to display the slideshows that are included
 * in this theme.
 *
 * @since 1.0.0
 * @version 1.0.0
 * @author Virginia Dooley <vcdooley@gmail.com>
 *
 */

//--------------- USEFUL NOTES ---------------//
/* MENU POSITION
In array: 'menu_position' => 20,
Heres What the values mean:
	0 - at the very top
	5 - below Posts
	10 - below Media
	15 - below Links
	20 - below Pages
	25 - below comments
	60 - below first separator
	65 - below Plugins
	70 - below Users
	75 - below Tools
	80 - below Settings
	100 - below second separator
*/

/**
 * mama_codes_custom_slider_init()
 * 
 * DEFINE CUSTOM POSTYPE
 * This function is repsonsible for creating our custom 
 * Slider Posttype and defining all of it's labels.
 * 
 * @version 1.0
 * 
 */
function mama_codes_custom_slider_init() {
	//Create an array of labels that we can pass into the 'label' attribute of the $arg array (More Specific Definitions)
	$slider_labels = array(
		'name'              	=> __('Gallery', 'theme-translate'),              		// Name of this Posttype.
		'singular_name'     	=> __('Slide', 'theme-translate'),                   		// Name of a Single Instance of this Posttype.
		'all_items'         	=> __('All Slides', 'theme-translate'),              		// Name of All Instances of this Posttype.
		'add_new'           	=> __('Add A New Slide', 'theme-translate'),         		// Name to Add a New Instance of this Posttype.
		'add_new_item'      	=> __('Add A New Slide', 'theme-translate'),         		// Name to Add a New Instance of this Posttype.	
		'edit_item'         	=> __('Edit This Slide', 'theme-translate'),         		// Label for Editing an Instance of this Posttype.
		'new_item'          	=> __('New Slide', 'theme-translate'),               		// Label for a New Singular Item of this Posttype.
		'view_item'         	=> __('View Slide', 'theme-translate'),              		// Label for Viewing a Singular Item of this Posttype.
		'search_items'      	=> __('Search in Slides', 'theme-translate'),        		// Label for Searching Items within this Posttype. 
		'not_found'         	=> __('No Slides Found', 'theme-translate'),         		// Label for when an Item of this Posttype is Not Found.
		'not_found_in_trash'	=> __('No Slides Found in Trash', 'theme-translate'),		// Message for when an Item of this Posttype is Not Found in Trash.
		'parent_item_colon' 	=> ''
		);

		$args = array(
		'labels'              => $slider_labels, 				// Name of post type itself as it is displayed in WordPress with label array above passed into it.
		'public'              => true, 							// Whether it is publically visible.
		'publicly_queryable'  => true,
		'show_ui'             => true, 							// So that you can see the UI when you are logged into WordPress.
		'query_var'           => true, 							// Whether we are able to programmatically query this content.
		'rewrite'             => true, 							// So that WordPress can rewrite the url for this post type.
		'exclude_from_search' => true, 							// Tells WordPress to include/exclude this post type from search results.
		'capability_type'     => 'post', 						// Can also set to 'page', this defines how WordPress handles the content.
		'hierarchical'        => true, 						// Allows for Heirachy.
		'menu_icon'           => 'dashicons-images-alt2',
		'menu_position'       => 20, 							// MENU POSITION - If required use the useful notes above as a guide to change the menu position of this posttype.
		'supports'            => array('title' ,'thumbnail', 'page-attributes', 'editor')	// Tells wordpress what features to support for this Posttype.
		);
		register_post_type('slides',$args); 		//Registers a new custom post type by passing in the name and the arguments defined above
}
add_action('init', 'mama_codes_custom_slider_init'); //Calls the function into WordPress at init (when WordPress admin boots up)

/**
 * mama_codes_custom_slider_taxonomies()
 *
 * DEFINE CUSTOM POSTYPE TAXONOMIES
 * This function is repsonsible for creating our custom
 * Slider Posttype taxonomies so that we are able to 
 * organise and group our slides into categories.
 *
 * @version 1.0
 *
 */
function mama_codes_custom_slider_taxonomies() {
	// SLIDER CATEGORIES	
	// 1ST STEP: Define an array of labels for our custom taxonomy.
	$sector_labels = array(
			'name'              => __( 'Slider Categories', 'theme-translate' ), 					// Name of Taxonomy.
			'singular_name'     => __( 'Slider Category', 'theme-translate' ), 						// Name of Singular Taxonomy.
			'search_items'      =>  __( 'Search Slider Catergories', 'theme-translate' ),			// Label for Searching this Taxonomy.
			'all_items'         => __( 'All Slider Categories', 'theme-translate' ), 				// Label for all taxonomies of this type.
			'most_used_items'   => null,
			'parent_item'       => null,
			'parent_item_colon' => null,
			'edit_item'         => __( 'Edit Slider Category', 'theme-translate' ),					// Label For: Edit Taxonomy.
			'update_item'       => __( 'Update Slider Category', 'theme-translate' ), 				// Label For: Updating the taxonomy.
			'add_new_item'      => __( 'Add New Slider Category', 'theme-translate' ), 				// Label For: Adding a new taxonomy.
			'new_item_name'     => __( 'New Slider Category', 'theme-translate' ), 					// Label For: New Taxonomy insatance name
			'menu_name'         => __( 'Slider Categories', 'theme-translate' ), 					// Label For: menu item
	);
	
	// 2ND STEP: Register our Custom Taxonomy with WordPress.
	
	// register_taxonomy() creates the new taxonomy for us and takes 3 arguments:
	// 1. The name of this taxonomy.
	// 2. An array of custom post types we are attaching this taxonomy to.
	// 3. An array of attributes for this taxonomy.
	// register_taxonomy('sliders', array('slides'), array(
	// 		'hierarchical' => true, 						// True or False.
	// 		'labels' => $sector_labels, 					// Labels for this taxonomy (PASS IN THE ARRAY DEFINED ABOVE).
	// 		'show_ui' => true, 								// Shows the UI for this custom taxonomy.
	// 		'query_var' => true, 							// Allows the content to be queryable.
	// 		'rewrite' => array('slug' => 'sliders' ) 		// Allows wordpress to rewite this url.
	// ));
}
add_action('init', 'mama_codes_custom_slider_taxonomies'); //Calls the function into wordpress at init (when wordpress admin boots up).


/**
 * slider_meta_box()
 * 
 * Creates a meta box to the custom Slider Posttype to allow
 * the user to specify a link destination for the slide.
 * 
 * @param object $post - The posttype post to add the metabox to.
 * 
 * @version 1.0
 * @author Sunny Johal - InSync IT
 * 
 */
function slider_meta_box( $post ) {
	$link_text           = get_post_meta( get_the_ID(), 'slider_meta_box_link', true );
	$btn_text            = get_post_meta( get_the_ID(), 'slider_button_text', true );
	$background_position = get_post_meta( get_the_ID(), 'slider_meta_box_background_position', true );
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
	<p>
		<label for="slider_button_text"><strong>Button Text:</strong></label>
		<input type="text" name="slider_button_text" id="slider_button_text" value="<?php echo $btn_text; ?>" class="widefat"/>
	</p>

	<p>
		<label for="slider_meta_box_link"><strong>Slide Link URL:</strong></label>
		<input type="text" name="slider_meta_box_link" id="slider_meta_box_link" value="<?php echo $link_text; ?>" class="widefat"/>
	</p>

	<p>
		<label for="slider_meta_box_background_position"><strong>Slide Background Position:</strong></label>
		<select name="slider_meta_box_background_position" id="slider_meta_box_background_position">
			<option value="center" <?php echo selected( $background_position, 'center' ); ?>>Center</option>
			<option value="top" <?php echo selected( $background_position, 'top' ); ?>>Top</option>
			<option value="bottom" <?php echo selected( $background_position, 'bottom' ); ?>>Bottom</option>
		</select>
	</p>
	
	<?php	
}

/**
 * save_slider_meta_box
 *
 * This function saves the data entered in our custom metabox with
 * WordPress so that it retains the data associated with this slide.
 *
 * @version 1.0
 * @author Sunny Johal - InSync IT
 *
 */
function save_slider_meta_box( $post_id )
{
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; // Bail if we're doing an auto save
	
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return; // If our nonce isn't there, or we can't verify it, bail

	// now we can actually save the data
	$allowed = array(
			'a' => array( 				// on allow a tags
					'href' => array()	// and those anchors can only have href attribute
			)
	);

	// Probably a good idea to make sure your data is set
	if( isset( $_POST['slider_meta_box_link'] ) ) {
		update_post_meta( $post_id, 'slider_meta_box_link', wp_kses( $_POST['slider_meta_box_link'], $allowed ) );
	}

	$btn_link = empty( $_POST['slider_button_text'] ) ? '' : esc_attr( $_POST['slider_button_text'] );
	update_post_meta( $post_id, 'slider_button_text', $btn_link );
}
add_action( 'save_post', 'save_slider_meta_box' ); //Hook our function so that it runs when WordPress saves this posttype.

/**
 * add_slider_meta_box
 * 
 * This function registers our custom metabox with
 * WordPress so that it displays it when the user 
 * adds a new slide.
 * 
 * @version 1.0
 * @author Sunny Johal - InSync IT
 * 
 */
function add_slider_meta_box() {
	add_meta_box( 
		'slider-meta-box', 
		__('Please insert the link for this slide in the text box below', 'theme-translate'), 
		'slider_meta_box', 
		'slides', 
		'normal', 
		'high'
	);
}
add_action( 'add_meta_boxes', 'add_slider_meta_box' );
