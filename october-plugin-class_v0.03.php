<?php

/**	This class helps to speed up the development of plugins 
 *	by providing all the base functionality required for a plugin.
 *	Plugins can then be built from a class that extends this class.
 *  See the example plugin for usage details
**/

/**	Copyright 2018 October Productions. All Rights Reserved.
 *	No unauthorised use, modification or duplication.
 *	Contact us for details: www.october.com.au
**/

/**
 *	Format of hash arrays used for css and js enqueueing
 *	"name" => Name of the css/js file without the ".css/.js". Also used for slug and js namespace. If this file is in the plugin root folder, no other info is needed. Required.
 *	"path" => Relative full path to the file. Eg, "css/mystyle.css". Path is relative to the root folder of the plugin. Optional.
 *	"url" => Full url (including protocol) to the file. Eg, "https://fontawesome.com/somefolder/finalfile.css". Optional.
 *	Example:

		public $extra_js = array(
			array(
				'name' => 'google_places',
				'url' => 'https://maps.googleapis.com/maps/api/js?key=AIzaxxxxwwwwCWzfl_oRoxxxxwwww5rLZl3k&libraries=places'
			)
		);

 *	
 *	The following files are enqueued automatically if they exist in the plugin root folder:
 *	slug.js				(namespace for localized data = slug [slug is sanitized for js, ie all nonalphanumerics are changed to '_' ] )
 *	slug.css
 *	slug_admin.js		(namespace for localized data = slug_admin [slug is sanitized for js, ie all nonalphanumerics are changed to '_' ] )
 *	slug_admin.css
 **/

/**
 *	Format of hash arrays used for adding a menu to the Admin screen
 *	"menu" => Menu to add this menu item to. Supported: "settings", "tools", "media", "menu" (the last one is for top level menus) (Required)
 *	The value of the menu item key is then another array containing ...
 *	"title" => Title of the page. Used in browser tabs, etc. (Optional. If omitted "label" will be used.)
 *	"label" => Label for the menu item in the admin menu. (Required)
 *	"template" => Full relative path of the php template file used to render this page (Required, except for "menu" type, where it is ignored)
 *
 *	The following items are used when the menu type is "menu" (for a top-level menu)
 *	"icon" => the url or string for the icon (see https://developer.wordpress.org/reference/functions/add_menu_page/) (Optional)
 *		For Dashicons, see https://developer.wordpress.org/resource/dashicons
 *	"position" => the integer order of the menu item in the admin menu (Optional)
 *	"submenus" => another array for each of the submenus for this top level menu. Uses the same three items as settings, tools and media menus above
 **/

/**
 *	Format of hash arrays used for adding custom post types
 *	"slug" => Slug for the new custom post type.
 *	The value of this key is then another array containing all the custom post type key/value pairs
 *	(See https://www.wpbeginner.com/wp-tutorials/how-to-create-custom-post-types-in-wordpress/ for details)
 *	Example:
 
		public $custom_post_types = array(		// override parent class property to fill with custom post types
			'jobs' => array(
				'custom_fields' => array(			// see http://blog.teamtreehouse.com/create-your-first-wordpress-custom-post-type
					'general' => array(				// this is a group of custom fields to be displayed together
						'slug' => 'general',
						'title' => 'General options',
//						'callback' => 'render_admin_job_general', // if no callback is given, the class default is used
						'context' => 'normal',		// location on edit screen: 'normal', 'side'
						'priority' => 'high',		// Priority of placement order: 'low', 'default', 'core', 'high'
						'fields' => array(			// an array of the actual custom fields names and types
							'job_location' => array(
								'label' => 'Job location',
								'type' => 'text'
							)
						)
					)
				),
				'labels' => array(
                	'name' => 'Jobs',
                	'singular_name' => 'Job',
					'menu_name' => 'Job Board',
					'all_items' => 'All Jobs',
					'view_item' => 'View Job',
					'add_new_item' => 'Add New Job',
					'add_new' => 'Add New Job',
					'edit_item' => 'Edit Job',
					'update_item' => 'Update Job',
					'search_items' => 'Search Jobs'
            	),
            	'public' => true,
				'show_in_menu' => true,
				'supports' => array( 'title', 'editor', 'author' ),
				'menu_position' => 2,
				'menu_icon' => 'dashicons-portfolio',
				'can_export' => true,
            	'has_archive' => true
			)
		);
 
 **/

/**
 *	Format of hash arrays used for adding custom taxonomies
 *	"slug" => Slug for the new custom taxonomy
 *	The value of this key is then another array containing all the taxonomy key/value pairs
 *	(See https://www.wpbeginner.com/wp-tutorials/create-custom-taxonomies-wordpress/ for details)
 *	Example:
 
		public $custom_taxonomies = array(		// override parent class property to fill with custom taxonomies
			'skills' => array(
				'post_types' => array( 'jobs' ),
				'labels' => array(
                	'name' => 'Skills',
                	'singular_name' => 'Skill',
					'menu_name' => 'Skills',
					'all_items' => 'All Skills',
					'view_item' => 'View Skill',
					'add_new_item' => 'Add New Skill',
					'add_new' => 'Add New Skill',
					'edit_item' => 'Edit Skill',
					'update_item' => 'Update Skill',
					'search_items' => 'Search Skills',
					'parent_item' => 'Skill Area',
					'parent_item_colon' => 'Skill Area:',
				),
            	'public' => true,
				'show_ui' => true,
				'show_admin_column' => true,
				'query_var' => true,
				'hierarchical' => true
			)
		);

**/

/**
 *	Format of hash arrays used for adding Buddypress submenu with add_bp_member_submenu( $data ) 
 *	Example:
 
	function add_bp_profile_test() {
		global $ojob;
		$data = array(
			'view_name' => "Resume",
			'view_slug' => "resume",
			'view_title' => "My Resume (title)",
			'view_content' => 'buddypress/members/single/testing',	// path within active theme
			'view_position' => 20,
			'edit_name' => "Edit Resume",
			'edit_slug' => "edit_resume",
			'edit_title' => "Edit My Resume (TITLE)",
			'edit_content' => 'buddypress/members/single/testing',	// path within active theme
			'edit_position' => 21
		);
		$ojob->add_bp_member_submenu( $data );
	}

	add_action( 'bp_setup_nav', 'add_bp_profile_test', 100 ); // then need to add the above function to the correct action 

 **/

/**
 *	Shortcodes
 *
 *	The shortcode tag ( eg [shortcode_tag] ) is the same as the slug provided when this class is extended.
 *	So if your plugin class slug is "myplugin", then your shortcode will be [myplugin].
 *	What happens after that depends on the contents of the $instance->shortcodes property.
 *
 *	Each element in the hash array is in the format command => array(), where command is the value for the
 *	command="" shortcode attribute. This allows the one shortcode to perform infinite different tasks.
 *	(eg [myplugin command="task1"], and then [myplugin command="task2"])
 *	If there will only be one command ever needed you can omit this attribute and the class will use
 *	whatever you define for 'default' as the command name. (See example below)
 *	
 *	The array attached to the command name is then the default values for all of the valid attributes allowed
 *	for that command. Any attribute encountered in the shortcode that does not have a default value is discarded/ignored.
 *	Every command array MUST include a 'callback' => 'method' pair, where 'pair' is the class method that will be
 *	called to generate the content for that command. All other attributes are optional and depend on your requirements.

 *	Example:

	public $shortcodes = array(
		'default'	=> array(				// if you use 'default' as the name, this is assumed if no command is provided in the shortcode
			'callback'	=> 'testShort',		// callback points to the function that will be performed. This is *required*.
			'att1'		=>	0,
			'att2'		=> 'value'
		),
		'load_posts'	=> array(
			'callback'	=> 'testShort',		// callback points to the function that will be performed. This is *required*.
			'att1'		=> 0,
			'test'		=> 'defaultValue'
		)
	);
		
**/


/**
 *	Changes to v0.03
 *	Custom field meta boxes				// Fixed a bug when rendering Admin meta boxes for custom fields 29/11/18
 *	Shortcode improvements				// Streamlined shortcodes and added extra debugging and error checking 23/11/18
 *	Added boolean field type 			// to custom post admin menu page; shows as checkbox 13/11/18
 *	Added add_bp_member_submenu()		// Adds a submenu to the Buddypress user profile page 10/11/18
**/


if( !class_exists( 'october_plugin' ) ) {
	class october_plugin {
		public $class_version	= 003;		// Version number of the october-plugin-class
		public $version			= 001;		// Version number of the subclass
		public $copyright		= '';		// Copyright notice
		public $slug 			= '';		// This slug is used as the short name for the plugin. Must be unique.
		public $js_slug			= '';		// The same slug, but sanitised for javascript (ie, dashes/dots change to underscore, etc)
		public $log_verbosity 	= 1;		// 0 = no logging, 1=errors/warnings only, 2=tracking, 3=all (very verbose, debugging only)
		public $args			= null; 	// Copy of the full args array passed upon instantiation
		public $extra_css		= null;		// Additional front-end CSS files to be enqueued (Override in subclass if required). See format above.
		public $extra_js		= null;		// Additional front-end JS files to be enqueued (Override in subclass if required). See format above.
		public $extra_admin_css	= null;		// Additional admin side CSS files to be enqueued (Override in subclass if required). See format above.
		public $extra_admin_js	= null;		// Additional admin side JS files to be enqueued (Override in subclass if required). See format above.
//		public $onInit			= null;		// Function to perform on init, when WordPress is loaded. (Override in subclass if required)
		public $admin_menus		= null;		// Admin menu item. (Override in subclass if required) See format above.
		public $shortcode_defaults = null;	// Default values for shortcode attributes. ALL expected attributes MUST be listed with a 
											// default value. Attributes not included in this list will be discarded if they are included
											// in the shortcode text on the page. (Override in subclass if required)
		public $shortcodes		= null;		// Functions to handle each shortcode "command" value. This is an array of "command" => "function" pairs.
											// If a given "command" value is not present, returns an error message. (Override in subclass if required)
											// The function called will receive a copy of all shortcode attributes.
		public $ajax_commands	= null;		// Functions to handle each ajax "command" value. This is an array of "command" => "function" pairs.
											// If a given "command" value is not present, returns an error message. (Override in subclass if required)
											// The function called can access the form data received in the $ajax_response array.
		public $ajax_response	= null;		// Array of key/value pairs that will be sent back to the calling client in json.
		public $ajax_response_text = '';	// json encoded copy of $ajax_response - sent in response to an ajax request
		public $ajax_users_only	= true;		// Flag. If true, only logged in users will be able to access admin-ajax.php. (Override to false in subclass if required)
		public $custom_post_types = null;	// Array of arrays, one for each custom post type
		public $custom_taxonomies = null;	// Array of arrays, one for each custom taxonomy
		public $custom_fields = null;		// Array of arrays, one for each custom field


		/**
		 *	Construct the plugin class object
		 * 
		 *	slug = Shortname for the plugin. Must be unique. (Required for full functionality)
		 *	args = array of arguments. (Optional)
		**/
		public function __construct( $slug = null ) {
			if( null !== $slug ) {
				$this->slug = $slug;
				$this->js_slug = preg_replace( "/[^a-zA-Z0-9]/", "_", $slug );
				// register actions for WordPress
				add_action( 'wp_ajax_nopriv_'.$slug, array( &$this, 'do_ajax' ) );
				add_action( 'wp_ajax_'.$slug, array( &$this, 'do_ajax' ) );
				add_action( 'wp_enqueue_scripts', array( &$this,'do_enqueues' ) );
				add_action( 'admin_enqueue_scripts', array( &$this,'do_admin_enqueues' ) );
				add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
				add_action( 'init', array(&$this, 'initialise') );
				add_action( 'init', array(&$this, 'create_custom_post_types') );
				add_action( 'init', array(&$this, 'create_custom_taxonomies') );
				add_action( 'admin_init', array(&$this, 'include_custom_fields') );
				// Add a shortcode
				add_shortcode( $this->slug, array(&$this, 'do_shortcode') );
			}
		} // END public function __contruct()
		

		
		/**
		 *	Write text to the default plugin output log
		 *	(This is a static function, so can be called without instantiating the class. eg october_plugin::slog(), or my_instance::slog() )
		 * 
		 *	errtext = Text string to be written (Optional)
		**/	
		public static function slog( $errtext = null ) {
				$errdate = date('D jS M Y h:i:s A');
				$errpath = $_SERVER['DOCUMENT_ROOT'];
				$mypath = sprintf("%s/plugin_log.txt", dirname( __FILE__ ) );
				error_log( $errdate.": ".$errtext."\n",3,$mypath );
		} // END public static function slog()
		
		/**
		 *	Write text to the default plugin output log
		 * 
		 *	verbosity_level = Level of the message. 0 = no logging, 1=errors/warnings only, 2=tracking, 3=all
		 *	errtext = Text string to be written (Optional)
		**/	
		public function log( $verbosity_level, $errtext = null ) {
			if( $verbosity_level <= $this->log_verbosity ) {
				$level = array( "", "! ","- ",". " );
				$this->slog( $level[ $verbosity_level].$this->slug."::".$errtext );
			}
		} // END public function log()

		
		/**
		 *	Do any other initialisation stuff that needs to occur after WordPress is loaded
		**/
		public function initialise() {
			$this->log( 3, "initialise() Started." );
			// Override this method with any initialisation needed
		} // END public static function initialise()
		
		
		/**
		 *	Methods to extract post data
		**/
		
		public static function get_posts( $args = null ) {
			october_plugin::slog( "get_posts() started." );
			if( null !== $args ) {
				global $wpdb;
				$cols = array_key_exists( 'cols', $args ) ? $args['cols'] : '*' ;
				$table = array_key_exists( 'table', $args ) ? $args['table'] : '' ;
				$sql = "SELECT $cols FROM $table";
				october_plugin::slog( "get_posts() SQL = ".$sql );
			}
		}
		
		public static function get_custom_posts( $args = null ) {
		}
		
		
		/**
		 *	If we have Custom Fields added, allow for them.
		**/
		
		public function include_custom_fields() {
			$this->log( 2, "include_custom_fields() Started." );
			if( null !== $this->custom_post_types ) {
				// We've confirmed we actually have custom post types, so proceed. Loop through all custom post types
				foreach( $this->custom_post_types as $ct_key => $ct_val ) {
					$this->log( 3, "include_custom_fields() Found Custom post ".$ct_key );
					if( array_key_exists( 'custom_fields', $ct_val) ) {
						// We've confirmed that this custom post type has custom fields, so proceed. Loop through all custom fields
						$fields = $ct_val['custom_fields'];
						$this->log( 3, "include_custom_fields() Custom post has custom fields: ".print_r($fields,true) );
						foreach( $fields as $cf_key => $cf_val ) {
							$this->add_custom_field_meta_box( $cf_key, $cf_val, $ct_key );
							// Add a callback to the save_post WordPress action hook to ensure the meta data is saved
							foreach( $cf_val['fields'] as $field_name => $fdata ) {
								$this->add_custom_field_callback( $field_name, $fdata );
							} // END of foreach
						} // END of foreach()
					} // END of if()
				} // END of foreach()
			} // END of if()
		} // END public function include_custom_fields()
		
		public function add_custom_field_meta_box( $cf_key, $cf_val, $parent = null ) {
			$this->log( 3, "add_custom_field_meta_box() Started. Add ".$cf_key );
			// Add a meta box for this custom field to the custom post admin screen
			$mytitle = array_key_exists( 'title', $cf_val ) ? $cf_val['title'] : $cf_val['slug'];
			$myrender = array_key_exists( 'callback', $cf_val ) ? $cf_val['callback'] : array(&$this, 'render_custom_meta_box');
			$mycontext = array_key_exists( 'context', $cf_val ) ? $cf_val['context'] : 'normal';
			$mypriority = array_key_exists( 'priority', $cf_val ) ? $cf_val['priority'] : 'default';
			add_meta_box( 
				$cf_val['slug'],		// slug or id for the meta box
				$mytitle,				// title of the meta box
				$myrender,				// callback method to render the meta box
				$parent,				// slug of the custom post this applies to
				$mycontext,				// where the meta box is placed on the edit screen, either 'normal' or 'side'
				$mypriority,			// the priority for placement order, one of 'low', 'default', 'core', 'high'
				$cf_val['fields']		// args passed to the callback function
			);
		}
		
		public function add_custom_field_callback( $field_name, $fdata ) {
			$this->log( 3, "add_custom_field_callback() Started. Add ".$field_name );
			if( array_key_exists( $field_name, $_POST ) ) {
				$newfuncname = "save_post_meta_".$field_name;
				$this->log( 3, "add_custom_field_callback() add_action outside newfuncname = ".$newfuncname );
				$this->{ $newfuncname } = function( $arga, $argb ) use ($field_name) {
					$this->log( 1, "add_custom_field_callback() add_action INSIDE post id = ".$arga );
					$this->log( 1, "add_custom_field_callback() add_action INSIDE field_name = ".$field_name );
					update_post_meta( $arga, $field_name, $_POST[ $field_name ] );
					if( 'parent' == $field_name ) {
						$argb->post_parent = $_POST[ $field_name ];
						$this->log( 1, "add_custom_field_callback() add_action INSIDE field is PARENT, post = ".print_r( $argb, true ) );
					}
				};
				add_action( 'save_post', $this->{ $newfuncname }, 10, 2 );
			} else {
//				$this->log( 1, "add_custom_field_callback() ".$field_name." doesn't exist in _POST" );
			} // END of if()
		}
		
		
		/**
		 *	Function to render out the contents of a custom field meta box
		 *	(See http://blog.teamtreehouse.com/create-your-first-wordpress-custom-post-type)
		 *	(See https://developer.wordpress.org/reference/functions/add_meta_box/)
		**/
		
		public function render_custom_meta_box( $mypost, $myargs ) {
			$this->log( 1, "render_custom_meta_box() Started. myargs=".print_r( $myargs,true ) );
			$this->log( 3, "args=".print_r( $myargs, true ) );
			foreach( $myargs['args'] as $field_name => $field_data ) {
				echo "<p><label>".$field_data['label']."</label>";
				$custom = get_post_custom( $mypost->ID );
				$current = array_key_exists( $field_name, $custom ) ? $custom[ $field_name ][0] : "";
				switch ( $field_data['type'] ) {
					case 'text':
						$size = array_key_exists( 'size', $field_data ) ? $field_data['size'] : 40;
						echo '<br /><input type="text" name="'.$field_name.'" value="'.$current.'" size="'.$size.'" />';
						break;
					case 'number':
						$min = array_key_exists( 'minimum', $field_data ) ? $field_data['minimum'] : 0;
						$max = array_key_exists( 'maximum', $field_data ) ? $field_data['maximum'] : 10;
						echo '<br /><input type="number" name="'.$field_name.'" value="'.$current.'" min="'.$min.'" max="'.$max.'" style="width: 9em;"/>';
						break;
					case 'date':
						echo '<br /><input type="date" name="'.$field_name.'" value="'.$current.'" />';
						// min / max support to come
						break;
					case 'time':
						echo '<br /><input type="time" name="'.$field_name.'" step="5" value="'.$current.'" />';
						break;
					case 'boolean':
						echo ' <input type="checkbox" name="'.$field_name.'" value="'.$current.'" style="padding: 2px 0px 0px 2px; width: 1.2em; height: 1.2em;"/>';
						break;
					case 'parent_drop':
						$pages = wp_dropdown_pages( 
							array( 
								'post_type' => $field_data['parent_type'], 
								'selected' => $mypost->post_parent, 
								'name' => 'parent',
								'show_option_none' => __( '(no parent)' ), 
								'sort_column' => 'menu_order, post_title', 
								'echo' => 0 
							) 
						);
						if ( ! empty( $pages ) ) {
							echo '<br />'.$pages;
						} else {
							echo "Couldn't create drop down";
						}
						break;
					default:
						echo '[unknown field type]';
						break;
				}
				echo "</p>\n";
			}
		}

		/**
		 *	If we have Custom Taxonomies added, create them
		**/
		
		public function create_custom_taxonomies() {
			$this->log( 3, "create_custom_taxonomies() Started." );
			if( null !== $this->custom_taxonomies ) {
				foreach( $this->custom_taxonomies as $ct_key => $ct_val ) {
					$this->log( 3, "create_custom_taxonomies() Register ct ".$ct_key );
					register_taxonomy( $ct_key, $ct_val[ 'post_types' ], $ct_val );
					// register the admin screen edit callback
					$hookname = $ct_key."_edit_form_fields";
					$this->log( 3, "create_custom_taxonomies() add action to hook ".$hookname );
//					add_action( $hookname, array(&$this, 'render_taxonomy_field_meta_box'), 10, 2 );
				}
			}
		}
		
		/**
		 *	Not yet implemented
		**/
		public function render_taxonomy_field_meta_box( $tag, $other ) {
			$this->log( 1, "render_taxonomy_field_meta_box() Started. tag = ".print_r( $tag, true ) );
//			$this->log( 3, "render_taxonomy_field_meta_box() taxonomy = ".$tag->taxonomy);
			$term_data = $this->custom_taxonomies[ $tag->taxonomy ];
//			$this->log( 3, "render_taxonomy_field_meta_box() data = ".print_r( $term_data, true ) );
			echo "<div style='width: 100%; background-color: #f2f2f2; border: 1px solid #777;'>";
			echo "<h2>Custom taxonomy fields</h2>";
			foreach( $term_data['custom_fields'] as $field ) {
				$this->log( 1, "render_taxonomy_field_meta_box() looping field = ".print_r( $field, true ) );
				echo "<p><label>".$field[ 'name' ]."</label><br />";
			}
			echo "</div>";
		}

		/**
		 *	If we have Custom Post Types added, create them
		**/
		
		public function create_custom_post_types() {
			$this->log( 3, "create_custom_post_types() Started." );
			if( null !== $this->custom_post_types ) {
				foreach( $this->custom_post_types as $cpt_key => $cpt_val ) {
					// Does this custom post type have a parent? If so, add custom field so we can later add a meta box to the sidebar
					if( array_key_exists( 'parent_type', $cpt_val ) ) {
						$this->log( 3, "create_custom_post_types() ".$cpt_key." has a parent." );
						$cpt_val = $this->add_custom_post_parent_meta( $cpt_key, $cpt_val );
						$this->custom_post_types[$cpt_key] = $cpt_val;
					}
					$this->log( 3, "create_custom_post_types() Register cpt ".$cpt_key." = ".print_r( $cpt_val,true) );
					register_post_type( $cpt_key, $cpt_val );
				}
				// this next bit ensures comments are enabled by default
				add_action('update_option', function() {
					update_option('default_comment_status', 'open');
				});
			}
		}
		
		public function add_custom_post_parent_meta( $cpt_key, $cpt_val ) {
			$this->log( 3, "add_custom_post_parent_meta() Started." );
			// Add a custom field for this custom post type to provide info regarding parent
			if( ! array_key_exists( 'custom_fields', $cpt_val )) {
				$this->log( 3, "add_custom_post_parent_meta() custom_fields does not yet exist." );
				$cpt_val['custom_fields'] = array();
				$this->log( 3, "add_custom_post_parent_meta() custom_fields added. ".print_r( $cpt_val, true ) );
			}
			$cpt_val['custom_fields']['parent'] = array(
					'slug' => 'post_parent',
					'title' => 'Parent',
					'context' => 'side',		// location on edit screen: 'normal', 'side'
					'priority' => 'default',		// Priority of placement order: 'low', 'default', 'core', 'high'
					'fields' => array(			// an array of the actual custom fields names and types
						'parent' => array(
							'label' => 'Select Parent',
							'type' => 'parent_drop',
							'parent_type' => $cpt_val['parent_type']
						)
					)
//				))
			);
			$this->log( 3, "add_custom_post_parent_meta() custom_fields parent added. ".print_r( $cpt_val, true ) );
			return $cpt_val;
		}

		/**
		 *	AJAX HANDLING
		 *
		 *	Handle ajax calls
		 *	The method looks for a $_POST key called "command", and uses the value of that key to match a key in the $ajax_commands
		 *	property, and uses the value of that as the name of a function to execute. 
		 *	
		 *	Eg
		 *	public $ajax_commands = array(
		 *		"testcommand" => "testfunc"
		 *	);
		 * 	
		 *	The above code will execute the method $my_instance->testfunc() when the ajax receives "command" => "testcommand".
		 *	The function can access all the form data through $my_instance->ajax_response['form']. It can send data back using
		 *	any added key=>value pairs on that array, or using the add_ajaxData() method below to add key/value pairs to the
		 *	$my_instance->ajax_response['data'] object, or using the push_ajaxData() method below to add an object to the
		 *	$my_instance->ajax_response['data'] array. The function should return 1 for successful completion, or 0 for 
		 *	error/incomplete (and add a meaningful error message to $my_instance->ajax_response['error'] ).
		**/
		public function do_ajax() {
			$this->log( 2, "do_ajax() Started." );

			// Set up an object to contain the response
			$this->ajax_response = array(
				'slug' => $this->slug,
				'form' => $_POST,
				'command' => $_POST[ 'command' ],
				'data' => array(),
				'result' => 0,
				'error' => 'Undefined error',
				'message' => ''
			);
			
			// if user is not logged in, and only logged in users are allowed, exit.
			if( ( true == $ajax_users_only ) && ( !is_user_logged_in() ) ) {
				$this->log( 3, "do_ajax() User is not logged in. Exit." );
				$this->ajax_response['error'] = "User is not logged in.";
				$this->ajax_response_text = json_encode($this->ajax_response);
				echo $this->response_text;
				wp_die();
			}

			// Confirm a valid nonce has been received. If not valid, exit.
			if( !wp_verify_nonce( $_POST['_ajax_nonce'], $this->slug."-ajax-nonce" ) ) {
				$this->log( 3, "do_ajax() Invalid nonce. Exit." );
				$this->ajax_response['error'] = "Nonce is invalid";
				$this->ajax_response_text = json_encode($this->ajax_response);
				echo $this->ajax_response_text;
				wp_die();
			}
			   
			// Process the contents of the ajax call
			if( null !== $this->ajax_response['command'] ) {		// make sure we actually received a command
				if( array_key_exists( $this->ajax_response['command'], $this->ajax_commands ) ) {
					$this->log( 3,"do_ajax() Execute class method ".$this->ajax_commands[ $this->ajax_response['command'] ] );
					$func = $this->ajax_commands[ $this->ajax_response['command'] ];
					$this->ajax_response['result'] = $this->$func( );
				} else {
					$this->ajax_response['error'] = "[ERROR. Unknown command '".$this->ajax_response['command']."']";
				}
			} else {
				$this->ajax_response['error'] = "No valid command provided.";
			}
			
			// All processing is complete. Encode the response and send it.
			$this->ajax_response_text = json_encode($this->ajax_response);
			$this->log( 3, "do_ajax() json=".$this->ajax_response_text );
			echo $this->ajax_response_text;
			wp_die();
		} // END public function do_ajax()
		
		/**
		 * Add data onto the ajax_response['data'] as an object
		**/
		public function add_ajaxData( $key = null , $value = null ) {
			$this->log( 2, "push_ajaxData() Started. key=".$key.", value=".$value );
			$this->ajax_response['data'][ $key ] = $value;
		}

		/**
		 * Push data onto the ajax_response['data'] as an array
		**/
		public function push_ajaxData( $value = null ) {
			$this->log( 2, "push_ajaxData() Started. key=".$key.", value=".$value );
			$this->ajax_response['data'][ $key ] = $value;
			array_push( $this->ajax_response[ 'data' ], $value );
		}

		
		/**
		 *	FRONT END SCRIPT AND STYLE ENQUEUES
		 *
		 *	Begins by enqueueing styles and scripts using only the slug provided on instantiation (eg slug.css and slug.js)
		 *	Then looks for any overrides for any other styles or scripts to enqueue
		**/
		public function do_enqueues() {
			$this->log( 3, "do_enqueues() Started. Slug='".$this->slug."', js slug='".$this->js_slug."'" );
			// enqueue all styles
			// First try to load a CSS style sheet with the slug name
			if( file_exists( plugin_dir_path( __FILE__ ).$this->slug.'.css' ) ) {
				wp_enqueue_style( $this->slug."_css", plugins_url( $this->slug.'.css', __FILE__ ) );
			}
			// Now load any additional CSS. Subclasses will need to override this property. See above.
			if( null !== $this->extra_css ) {
				$this->log( 3, "do_enqueues() Property overridden. Additional CSS files need to be enqueued." );
				foreach( $this->extra_css as $extra ) {
					$this->log( 3, "do_enqueues() Enqueue CSS file: ".$extra['name'] );
					if( array_key_exists( 'path', $extra ) ) { 			// path has been supplied. Enqueue using path.
						$this->log( 3, "do_enqueues() Enqueue CSS file: ".$extra['name']." using path ".$extra['path'] );
						wp_enqueue_style( $extra['name']."_css", plugins_url( $extra['path'], __FILE__ ) );
					} elseif ( array_key_exists( 'url', $extra ) ) {	// url has been supplied. Enqueue using url.
						$this->log( 3, "do_enqueues() Enqueue CSS file: ".$extra['name']." using url ".$extra['url'] );
						wp_enqueue_style( $extra['name']."_css", $extra['url'] );
					} else {		// no path or url has been supplied. Enqueue assuming the named file is in the plugin root folder
						$this->log( 3, "do_enqueues() Enqueue CSS file: ".$extra['name']." using root folder file ".$extra['name'].".css" );
						wp_enqueue_style( $extra['name']."_css", plugins_url( $extra['name'].".css", __FILE__ ) );
					}
				} // END foreach
			} // END if()
			
			// enqueue all scripts ( handle, script source, dependencies )
			// First try to load a JS file with the slug name
			$this->log( 3, "do_enqueues() Checking for default javascript file = ".plugin_dir_path( __FILE__ ).$this->slug.'.js' );
			if( file_exists( plugin_dir_path( __FILE__ ).$this->slug.'.js' ) ) {
				$this->log( 3, "do_enqueues() Default javascript file detected. slug = ".$this->js_slug );
				wp_enqueue_script( $this->slug."_js",  plugins_url( $this->slug.'.js', __FILE__ ) , array('jquery') );
				// the localise below is to get the admin-ajax url and other vital info to the javascript file = handle, variable namespace, data
				wp_localize_script( $this->slug."_js", $this->js_slug, array( 
													'pluginsUrl' => plugins_url(),
					   								'ajaxUrl' => admin_url( 'admin-ajax.php' ),
													'wnonce' => wp_create_nonce( $this->slug."-ajax-nonce" )
				) );
			}
			// Now load any additional JS. Subclasses will need to override this property. See above.
			if( null !== $this->extra_js ) {
				$this->log( 3, "do_enqueues() Property overridden. Additional JS files need to be enqueued." );
				foreach( $this->extra_js as $extra ) {
					$this->log( 3, "do_enqueues() Enqueue JS file: ".$extra['name'] );
					if( array_key_exists( 'path', $extra ) ) { 			// path has been supplied. Enqueue using path.
						$this->log( 3, "do_enqueues() Enqueue JS file: ".$extra['name']." using path ".$extra['path'] );
						wp_enqueue_script( $extra['name']."_js", plugins_url( $extra['path'], __FILE__ ) );
					} elseif ( array_key_exists( 'url', $extra ) ) {	// url has been supplied. Engueue using url.
						$this->log( 3, "do_enqueues() Enqueue JS file: ".$extra['name']." using url ".$extra['url'] );
						wp_enqueue_script( $extra['name']."_js", $extra['url'] );
					} else {		// no path or url has been supplied. Enqueue assuming the named file is in the plugin root folder
						$this->log( 3, "do_enqueues() Enqueue JS file: ".$extra['name']." using root folder file ".$extra['name'].".js" );
						wp_enqueue_script( $extra['name']."_js", plugins_url( $extra['name'].".js", __FILE__ ) );
					}
					// the localise below is to get the admin-ajax url and other vital info to the javascript file = handle, variable namespace, data
					wp_localize_script( $extra['name']."_js", $extra['name'], array( 
															'pluginsUrl' => plugins_url(),
							   								'ajaxUrl' => admin_url( 'admin-ajax.php' ),
															'wnonce' => wp_create_nonce( $extra['name']."-ajax-nonce" )
					) );
				} // END foreach
			} // END if()

		} // END public function do_enqueues()

		
		/**
		 *	ADMIN SCRIPT AND STYLE ENQUEUES
		 *
		 *	Begins by enqueueing styles and scripts using only the slug provided on instantiation (eg slug.css and slug.js)
		 *	Then looks for any overrides for any other styles or scripts to enqueue
		**/
		public function do_admin_enqueues() {
			$this->log( 3, "do_admin_enqueues() Started. Slug='".$this->slug."'" );
			// enqueue all styles
			// First try to load a CSS style sheet with the slug name plus "_admin"
			if( file_exists( plugin_dir_path( __FILE__ ).$this->slug.'_admin.css' ) ) {
				wp_enqueue_style( $this->slug."_admin_css", plugins_url( $this->slug.'_admin.css', __FILE__ ) );
			}
			// Now load any additional CSS. Subclasses will need to override this property. See above.
			if( null !== $this->extra_admin_css ) {
				$this->log( 3, "do_admin_enqueues() Property overridden. Additional CSS files need to be enqueued." );
				foreach( $this->extra_admin_css as $extra ) {
					$this->log( 3, "do_admin_enqueues() Enqueue CSS file: ".$extra['name'] );
					if( array_key_exists( 'path', $extra ) ) { 			// path has been supplied. Enqueue using path.
						$this->log( 3, "do_admin_enqueues() Enqueue CSS file: ".$extra['name']." using path ".$extra['path'] );
						wp_enqueue_style( $extra['name']."_css", plugins_url( $extra['path'], __FILE__ ) );
					} elseif ( array_key_exists( 'url', $extra ) ) {	// url has been supplied. Engueue using url.
						$this->log( 3, "do_admin_enqueues() Enqueue CSS file: ".$extra['name']." using url ".$extra['url'] );
						wp_enqueue_style( $extra['name']."_css", $extra['url'] );
					} else {		// no path or url has been supplied. Enqueue assuming the named file is in the plugin root folder
						$this->log( 3, "do_admin_enqueues() Enqueue CSS file: ".$extra['name']." using root folder file ".$extra['name'].".css" );
						wp_enqueue_style( $extra['name']."_css", plugins_url( $extra['name'].".css", __FILE__ ) );
					}
				} // END foreach
			} // END if()
			
			// enqueue all scripts ( handle, script source, dependencies )
			// First try to load a JS file with the slug name
			if( file_exists( plugin_dir_path( __FILE__ ).$this->slug.'_admin.js' ) ) {
				wp_enqueue_script( $this->slug."_admin_js",  plugins_url( $this->slug.'_admin.js', __FILE__ ) , array('jquery') );
				wp_localize_script( $this->slug."_admin_js", $this->js_slug."_admin", array( 
													'pluginsUrl' => plugins_url(),
					   								'ajaxUrl' => admin_url( 'admin-ajax.php' ),
													'wnonce' => wp_create_nonce( $this->slug."_admin-ajax-nonce" )
				) );
			}
			// Now load any additional JS. Subclasses will need to override this property. See above.
			if( null !== $this->extra_admin_js ) {
				$this->log( 3, "do_admin_enqueues() Property overridden. Additional JS files need to be enqueued." );
				foreach( $this->extra_admin_js as $extra ) {
					$this->log( 3, "do_admin_enqueues() Enqueue JS file: ".$extra['name'] );
					if( array_key_exists( 'path', $extra ) ) { 			// path has been supplied. Enqueue using path.
						$this->log( 3, "do_admin_enqueues() Enqueue JS file: ".$extra['name']." using path ".$extra['path'] );
						wp_enqueue_script( $extra['name']."_js", plugins_url( $extra['path'], __FILE__ ) );
					} elseif ( array_key_exists( 'url', $extra ) ) {	// url has been supplied. Engueue using url.
						$this->log( 3, "do_admin_enqueues() Enqueue JS file: ".$extra['name']." using url ".$extra['url'] );
						wp_enqueue_script( $extra['name']."_js", $extra['url'] );
					} else {		// no path or url has been supplied. Enqueue assuming the named file is in the plugin root folder
						$this->log( 3, "do_admin_enqueues() Enqueue JS file: ".$extra['name']." using root folder file ".$extra['name'].".js" );
						wp_enqueue_script( $extra['name']."_js", plugins_url( $extra['name'].".js", __FILE__ ) );
					}
					// the localise below is to get the admin-ajax url and other vital info to the javascript file = handle, variable name, data
					wp_localize_script( $extra['name']."_admin_js", $extra['name'], array( 
															'pluginsUrl' => plugins_url(),
							   								'ajaxUrl' => admin_url( 'admin-ajax.php' ),
															'wnonce' => wp_create_nonce( $extra['name']."_admin-ajax-nonce" )
					) );
				} // END foreach
			} // END if()

		} // END public function do_admin_enqueues()


		
		
		/**
		 *	SHORTCODES
		 *
		 *	Handles the shortcode for this plugin.
		 *	See explanation at top of the file.
		 *
		**/
		
		public function do_shortcode( $atts, $content ) {
			$this->log( 2,"do_shortcode() Started." );
			$textout = "";
			
			// check that the shortcode property has been over-ridden with some values.
			if( null !== $this->shortcodes ) {
				$this->log( 3,"do_shortcode() shortcodes=".print_r( $this->shortcodes, true ) );
				// the shortcode property has been overridden, so we're good to go

				// check to see if a command has been provided in the shortcode. If it has, use it; otherwise use 'default'.
				$command = ( array_key_exists( 'command', $atts ) ) ? $atts[ 'command' ] : 'default';
				$this->log( 3,"do_shortcode() command=".$command );
				
				// check to see if the determined command is included in the overridden shortcodes property
				if( array_key_exists( $command, $this->shortcodes ) ) {
					
					// the command is in the array, so we can now use the default attribute values.
					$allatts = shortcode_atts( $this->shortcodes[ $command ], $atts ); // merge the defaults with the shortcode attributes
					$this->log( 3,"do_shortcode() allatts=".print_r( $allatts, true ) );
					
					// check that the callback has been defined
					if( array_key_exists( 'callback', $this->shortcodes[ $command ] ) ) {
						$func = $this->shortcodes[ $command ][ 'callback' ];
						
						// check that the callback function exists in the instance
						if( method_exists( $this, $func ) ) {
							$this->log( 2,"do_shortcode() Shortcode command ".$command." is valid. Calling callback method." );
							$textout = $this->$func( $allatts ); // call the callback, which returns the content for the shortcode
						} else {
							$this->log( 1,"do_shortcode() [ERROR. Callback for ".$command." is defined but does not exist.]" );
							$textout = "[ERROR. Callback for ".$command." is defined but does not exist.]";
						}
						
					} else {
						$this->log( 1,"do_shortcode() [ERROR. No callback defined for ".$command."]" );
						$textout = "[ERROR. No callback defined for ".$command."]";
					}
					
				} else {
					// the command does not exist in the shortcodes property so we don't know what to do. Return an error message.
					$this->log( 1,"do_shortcode() [ERROR. Unknown command. (".$command.")]" );
					$textout = "[ERROR. Unknown command. (".$command.")]";
				}

			} else {
				// the shortcode property has not been overridden, so we return an error message.
				$this->log( 1,"do_shortcode() [ERROR. Shortcode is not supported.]" );
				$textout = "[ERROR. Shortcode is not supported.]";
			}
			return $textout;
			
		} // END public function do_shortcode()
		
		
		

		
		/**
		 *	ADMIN MENUS
		 *
		 *	Handle all creation and display of menu items added to the admin side of WordPress.
		 *	Multiple menu items can added for the one plugin. All information is provided by overriding the
		 *	$admin_menus property of this class.
		 *
		 *	EG. To add a single submenu item to the standard Admin Settings menu:
		 *	public $admin_menus = array (
		 *		"settings" => array (
		 *			"label" => "October Settings",					// The label that will be used for the menu
		 *			"template" => "templates/admin_settings.php"	// The php file that will be displayed when the menu is selected
		 *		)
		 *	);
		**/
		public function add_admin_menus() {
			$this->log( 3,"add_admin_menus() Started." );
			if( null !== $this->admin_menus ) {
				$this->log( 1,"add_admin_menus() There is at least one menu to add to the Admin screen." );
				$this->do_admin_menu( 'settings' );
				$this->do_admin_menu( 'tools' );
				$this->do_admin_menu( 'media' );
				if( array_key_exists( 'menu', $this->admin_menus ) ) {
					$menu = $this->admin_menus['menu'];
					$this->log( 3,"add_admin_menus() Add a top-level item to the Admin menu.".print_r( $menu, true ) );
					add_menu_page(
						( array_key_exists( 'title', $menu ) ? $menu[ 'title' ] : $menu[ 'label' ] ),
						$menu[ 'label' ],
						"manage_options",
						$this->slug."_menu",
						null, // if this is null, it defaults to submenu 0, which is a good thing
						( array_key_exists( 'icon', $menu ) ? $menu[ 'icon' ] : null ),
						( array_key_exists( 'position', $menu ) ? $menu[ 'position' ] : null )
					);
					// now do the submenus
					$submenuslug = 0;
					if( array_key_exists( 'submenus', $menu ) ) {
						foreach( $menu['submenus'] as $submenu ) {
							$this->log( 3,"add_admin_menus() Add a submenu to a top-level item in the Admin menu.".print_r( $submenu, true ) );
							add_submenu_page(
								$this->slug."_menu",
								( array_key_exists( 'title', $menu ) ? $submenu[ 'title' ] : $submenu[ 'label' ] ),
								$submenu[ 'label' ],
								"manage_options",
								$this->slug."_submenu_".$submenuslug++,
								array( &$this, 'display_admin_screen' )
							);
						} // END foreach()
						// WordPress adds a submenu to Admin menus identical to the main menu item. Remove it.
						remove_submenu_page( $this->slug."_menu", $this->slug."_menu" );
					} // END if
				} // END if
			} // END if
		} // END public function add_menus()
		
		/**	
		 *	Shortcut method for adding items to the standard WordPress admin menus
		 *	Called from add_admin_menus().
		 *	(Custom top level menus and submenus are added in add_admin_menus() )
		**/
		public function do_admin_menu( $type ) {
			$this->log( 1,"do_admin_menus() Started. type=".$type );
			$functionName = array(
				"settings" => "add_options_page",
				"tools" => "add_management_page",
				"media" => "add_media_page"
			);
			if( array_key_exists( $type, $this->admin_menus ) ) {
				$menu = $this->admin_menus[ $type ];
				$this->log( 3,"do_admin_menu() Add an item to the ".$type." menu.".print_r( $menu, true ) );
				$functionName[ $type ](
					( array_key_exists( 'title', $menu ) ? $menu[ 'title' ] : $menu[ 'label' ] ),
					$menu[ 'label' ],
					"manage_options",
					$this->slug."_".$type."_menu",
					array( &$this, 'display_admin_screen' )
				);
			} // END if		
		} // END public function do_admin_menu()
		
		/**	
		 *	This method is used for displaying all admin menu pages/screens
		 *	Added to every menu item as the display callback method in both add_admin_menus() and do_admin_menu().
		 *	Determines what menu is being requested, then calls display_menu_page() with the required menu data.
		**/
		public function display_admin_screen( ) {
			$this->log( 3,"display_admin_screen() Started." );
			// learn about the admin menu page that WordPress wants to show
			$currentScreen = get_current_screen();
			$type = $this->get_currentScreenType( $currentScreen );
			$tlmenu = $this->slug."_menu";
//			$this->log( 2,"display_admin_screen() currentScreen=".print_r( $currentScreen, true) );
//			$this->log( 2,"display_admin_screen() currentScreen->parent=".$currentScreen->parent_base );
			$this->log( 3,"display_admin_screen() currentScreen->id = ".$currentScreen->id );
			$this->log( 3,"display_admin_screen() currentScreen type = ".$type );
			switch( $type ) {
				case 'tools':
				case 'settings':
				case 'media':
					// Display a standard WordPress menu item sub-item
					$this->log( 3,"display_admin_screen() Show page for standard WordPress menu sub-item." );
					if( array_key_exists( $type, $this->admin_menus ) ) {
						$this->display_menu_page( $this->admin_menus[ $type ] );
					} else {
						$this->log( 1,"display_admin_screen() Admin menu information not found for ".$currentScreen->id );
						echo "Admin menu information not found for ".$currentScreen->id;
					}
					break;
				case $tlmenu:
					$this->log( 3,"display_admin_screen() Show page for custom top-level menu sub-item." );
					$myslug = $this->slug."_submenu_";
					$index_pos = strpos( $currentScreen->id, $myslug ) + strlen( $myslug );
					if( false == $index_pos ) {
						$this->log( 1,"display_admin_screen() ERROR cannot find submenu index page for custom top-level menu sub-item ".$currentScreen->id );
						echo "ERROR cannot find submenu index page for custom top-level menu sub-item ".$currentScreen->id;
					} else {
						$index = (int)substr( $currentScreen->id, $index_pos );
						if( array_key_exists( 'submenus', $this->admin_menus[ 'menu' ] ) ) {
							if( array_key_exists( $index, $this->admin_menus[ 'menu' ]['submenus'] ) ) {
								$submenu = $this->admin_menus[ 'menu' ]['submenus'][$index];
								$this->log( 3,"display_admin_screen() submenu = ".print_r( $submenu,true) );
								$this->display_menu_page( $submenu );
							} else {
								$this->log( 1,"display_admin_screen() Admin submenu (index) information not found for ".$currentScreen->id );
								echo "Admin submenu (index) information not found for ".$currentScreen->id;
							}
						} else {
							$this->log( 1,"display_admin_screen() Admin submenu (all) information not found for ".$currentScreen->id );
							echo "Admin submenu (all) information not found for ".$currentScreen->id;
						}
					}
					break;
				default:
					echo 'display_admin_screen() Cannot find page for '.$currentScreen->id." = ".$type."<br/ >";
					break;
			}
		} // END public function display_admin_screen()
		
		/**
		 *	Determine the admin screen type given a currentScreen object
		**/
		public function get_currentScreenType( $cs ) {
			$type = $cs->parent_base;
			$type = ( 'options-general' == $type ) ? 'settings' : $type;
			$type = ( 'upload' == $type ) ? 'media' : $type;
			return $type;
		}
		
		/**	
		 *	This method is used for displaying all admin menu pages/screens
		 *	Called from display_admin_screen() with the data from the $admin_menus property specific to the required page.
		**/
		public function display_menu_page( $menu ) {
			// Display the php file for the select menu
			$this->log( 3,"display_menu_page() Started." );
			if( !current_user_can( 'manage_options' ) ) {
				$this->log( 2,"display_menu_page() Die. User has insufficient permission." );
				wp_die(__('You do not have sufficient permissions to administer this system.'));
			} else {
				$this->log( 3,"display_menu_page() Display menu page." );
				if( array_key_exists( 'template', $menu ) ) {
				    include( sprintf( "%s/%s", dirname(__FILE__), $menu[ 'template' ] ) );
				} else {
					$this->log( 1,"display_menu_page() Admin menu page not found: ".print_r( $menu, true ) );
					echo "<pre>Admin menu page not found: ".print_r( $menu, true )."</pre>" ;
				}
			} // END if / else	
		}

		

		/**
		 *	PRINT METHODS
		 *
		 *	A collection of helper methods to assist primarily in building admin pages
		**/
		
		public function print_header() {
			$currentScreen = get_current_screen();
			$type = $this->get_currentScreenType( $currentScreen );
			$tlmenu = $this->slug."_menu";
			$name = "";
			$sub = "";
			switch( $type ) {
				case 'tools':
				case 'settings':
				case 'media':
					$name = $this->admin_menus[ $type ][ 'label' ];
					break;
				case $tlmenu:
					$name = $this->admin_menus[ 'menu' ][ 'label' ];
					$myslug = $this->slug."_submenu_";
					$index_pos = strpos( $currentScreen->id, $myslug ) + strlen( $myslug );
					if( false !== $index_pos ) {
						$index = (int)substr( $currentScreen->id, $index_pos );
						if( array_key_exists( 'submenus', $this->admin_menus[ 'menu' ] ) ) {
							$sub = $this->admin_menus[ 'menu' ]['submenus'][$index][ 'label' ];
						}
					}
					break;
			}
			echo "<h1 style='font-size: 2.1em; font-weight: 500;'>".$name."</h1>";
			echo "<div style='padding-bottom: 1em;'>";
			if( $this->version ) {
				echo "<span style='font-size: 0.9em;'>v".number_format((float)($this->version/100), 2, '.', '')." </span>";
			}
			if( strlen( $this->copyright ) > 0 ) {
				echo "<span style='font-size: 1.1em;'>&copy;".$this->copyright."</span>";
			}
			if( strlen( $sub ) > 0 ) {
				echo "<h2 style='padding-top: 1.5em; margin: 0px; font-size: 1.8em; font-weight: 500;'>".$sub."</h2>";
			}
			echo "</div>";
		}
		
		
		/**
		 *	BUDDYPRESS METHODS
		 *
		 *	A collection of helper methods to assist in modifying Buddypress
		**/
		
		function add_bp_member_submenu( $data ) {
			global $bp;
			$userid = bp_displayed_user_id();
			$userdomain = bp_core_get_user_domain( $userid );

			if( ( array_key_exists( "view_name", $data ) ) && ( array_key_exists( "view_slug", $data ) ) && ( array_key_exists( "view_content", $data ) ) ) {
		
				// create a function to display the contents of the 'view' submenu item
				$viewme = null;
				if( array_key_exists( "view_title", $data ) ) { // if title has been given, include it
					$viewme = function() use( $data ) {
						add_action( 'bp_template_title', function() use( $data ) {
							echo $data[ 'view_title' ];
						} );
						bp_core_load_template( $data[ 'view_content' ] );	// without this, the page doesn't load and you get a 404 error!! 
						add_action( 'bp_template_content', function() use( $data ) {
							bp_get_template_part( $data[ 'view_content' ] );
						} );
					};
				} else { // otherwise, just use the contents template
					$viewme = function() use( $data ) {
						bp_core_load_template( $data[ 'view_content' ] );	// without this, the page doesn't load and you get a 404 error!! 
						add_action( 'bp_template_content', function() use( $data ) {
							bp_get_template_part( $data[ 'view_content' ] );
						} );
					};
				}
		
				// now use all that info to create the submenu item
				bp_core_new_subnav_item( array(
					// these array keys MUST exist ( or we wouldn't have even got this far )
					'name' => $data[ 'view_name' ],
					'slug' => $data[ 'view_slug' ],
					'default_subnav_slug' => $data[ 'view_slug' ],
					'screen_function' => $viewme,
					// these array keys are optional and use defaults if not present
					'parent_slug' => ( array_key_exists( "parent_slug", $data ) ) ? $data[ 'parent_slug' ] : $bp->profile->slug,
					'parent_url' => ( array_key_exists( "parent_slug", $data ) ) ? trailingslashit( $userdomain.$data[ 'parent_slug' ] ) : bp_displayed_user_domain().'profile/',
					'position' => ( array_key_exists( "edit_position", $data ) ) ? $data[ 'edit_position' ] : 99
					)
				);		
//				$this->log( 1, "add_bp_member_submenu() bp->members->nav = ".print_r( $bp->members->nav, true ));
			}
	
			// if this is the admin, or the current user is the same as the displayed user, show the edit item if it exists
			if( bp_is_my_profile() || current_user_can('administrator') ) {
				if( ( array_key_exists( "edit_name", $data ) ) && ( array_key_exists( "edit_slug", $data ) ) && ( array_key_exists( "edit_content", $data ) ) ) {

					// create a function to display the contents of the 'edit' submenu item
					$editme = null;
					if( array_key_exists( "edit_title", $data ) ) { // if title has been given, include it
						$editme = function() use( $data ) {
							add_action( 'bp_template_title', function() use( $data ) {
								echo $data[ 'edit_title' ];
							} );
							bp_core_load_template( $data[ 'edit_content' ] );	// without this, the page doesn't load and you get a 404 error!! 
							add_action( 'bp_template_content', function() use( $data ) {
								bp_get_template_part( $data[ 'edit_content' ] );
							} );
						};
					} else { // otherwise, just use the contents template
						$editme = function() use( $data ) {
							bp_core_load_template( $data[ 'edit_content' ] );	// without this, the page doesn't load and you get a 404 error!! 
							add_action( 'bp_template_content', function() use( $data ) {
								bp_get_template_part( $data[ 'edit_content' ] );
							} );
						};
					}
			
					// now use all that info to create the submenu item
					bp_core_new_subnav_item( array(
						// these array keys MUST exist ( or we wouldn't have even got this far )
						'name' => $data[ 'edit_name' ],
						'slug' => $data[ 'edit_slug' ],
						'default_subnav_slug' => $data[ 'edit_slug' ],
						'screen_function' => $editme,
						// these array keys are optional and use defaults if not present
						'parent_slug' => ( array_key_exists( "parent_slug", $data ) ) ? $data[ 'parent_slug' ] : $bp->profile->slug,
						'parent_url' => ( array_key_exists( "parent_slug", $data ) ) ? trailingslashit( $userdomain.$data[ 'parent_slug' ] ) : bp_displayed_user_domain().'profile/',
						'position' => ( array_key_exists( "edit_position", $data ) ) ? $data[ 'edit_position' ] : 99
						)
					);	
//					$this->log( 1, "add_bp_member_submenu() bp->members->nav = ".print_r( $bp->members->nav, true ));
				}
			}
		}

		
		
		 
	} // END of class
} // END if

?>