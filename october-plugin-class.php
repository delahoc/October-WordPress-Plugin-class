<?php

/**	This class helps to speed up the development of plugins 
 *	by providing all the base functionality required for a plugin.
 *	Plugins can then be built from a class that extends this class.
 *  See the example plugin and this file for usage details
**/

/**	Copyright 2018, 2019 October Productions. All Rights Reserved.
 *	No unauthorised use, modification or duplication.
 *	Contact us for details: www.october.com.au
**/

/**
 *	CSS and Javascript enqueuing
 *
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
 *	slug.js				(namespace for localized data = slug [slug is sanitised for js, ie all nonalphanumerics are changed to '_' ] )
 *	slug.css
 *	slug_admin.js		(namespace for localized data = slug_admin [slug is sanitised for js, ie all nonalphanumerics are changed to '_' ] )
 *	slug_admin.css
 **/

/**
 *	Admin menus
 *
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
 *	"submenus" => another array for each of the submenus for this top level menu. 
 *			Uses the same three items as settings, tools and media menus above.
 *			Key for each entry is the ordinal position for the submenu, starting at 0
 *
 *	Example:
 		public $admin_menus = array(
			'menu' => array(
				'title' => 'My test menu',				// Used for browser tabs
				'label' => 'Test menu',					// Text of actual menu item
				'icon'	=> 'dashicons-admin-tools',		// See above for link to dashicons
				'position' => 30,						// See positions explained in the developer.wordpress.org link above
				'submenus' => array(
					'0' => array(
						'title' => 'First submenu',
						'label' => 'The first submenu',
						'template' => 'templates/menu-first.php'	// path is relative to the main plugin file.
					),
					'1' => array(
						'title' => 'Second submenu',
						'label' => 'The second submenu',
						'template' => 'templates/menu-second.php'	// path is relative to the main plugin file.
					)
				)
 			),
			'settings' => array(
				'title' => 'My test settings submenu',
				'label' => 'Test Setting Submenu',
				'template' => 'templates/settings-submenu.php'		// path is relative to the main plugin file.
			)
		);
		
 **/

/**
 *	Custom Post Types
 *
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
 *	Custom Taxonomies
 *
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
 *	Every command array MUST include a 'callback' => 'method' pair, where 'method' is the class method that will be
 *	called to generate the content for that command. All other attributes are optional and depend on your requirements.
 *	As with all WordPress shortcodes, the callback method receives one argument - an array of the shortcode attributes.

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

 *	This example will permit the use of either of these shortcodes:
 *	[myplugin att1="99"]
 *	[myplugin command="load_posts" test="newValue"]
		
**/

/**
 *	AJAX HANDLING
 *
 *	Handle ajax calls
 *	The class looks for a $_POST key called "command", and uses the value of that key to match a key in the $ajax_commands
 *	property, and uses the value of that as the name of a function to execute. The class automatically adds a hook
 *	into the WordPress ajax handlers equal to the slug of the plugin, similar to the way this class handles shortcodes (above),
 *	which means WordPress will be looking for a 'action' => 'slug' pair in the ajax call data. If WordPress receives 
 *	such a pair, it passes control to the class, and the class then looks for a 'command' => '[insert your command]' pair.
 *	
 *	Eg
 *	public $ajax_commands = array(
 *		"testcommand" => "testfunc"
 *	);
 * 	
 *	The above code will execute the method $my_instance->testfunc() when the ajax receives "command" => "testcommand".
 *	This means at a minimum, your ajax call must include:
 *		'action' => 'slug',
 *		'command' => 'something'
 *	You may also want to include a WordPress nonce is this call is only permitted by a logged in user.
 *	The function can access all the form data through $my_instance->ajax_response['form']. It can send data back using
 *	any added key=>value pairs on that array, or using the add_ajaxData() method to add key/value pairs to the
 *	$my_instance->ajax_response['data'] object, or using the push_ajaxData() method below to add an object to the
 *	$my_instance->ajax_response['data'] array. The method should return 1 for successful completion, or 0 for 
 *	error/incomplete (and add a meaningful error message to $my_instance->ajax_response['error'] ).
**/

/**
 *	Custom Database
 *	
 *	Easily create a custom MySQL database inside your WordPress installation.
 *	The class automatically adds a menu to the admin screen for your database for quick viewing and editing of data.
 *	You can have multiple tables within the database, and define exactly all of the columns within.
 *	The class automatically creates columns for a unique record id, a creation date and a last modified date.
 *	The class also uses WordPress List Tables to create the admin screens, and the method used
 *	here to create those tables can also be used to simplify the creation of List Tables for other purposes.
 *
 *	Override the property custom_db to define your custom database:
 
 		public $custom_db = array(
			'menuName'	=> 'oRater Database',			// label given in the admin menu
			'pageTitle' => 'oRater Database page',		// page title for the admin page
			array(
				'name' => 'rating_category',		// table name. No spaces, etc, as per usual MySQL rules
				'cols' => array(					// define all the columns
					// a column called 'id' will be added automatically (id mediumint(9) NOT NULL AUTO_INCREMENT) (UNIQUE KEY id (id))
					// a column called 'created' will be added automatically 
					// a column called 'modified' will be added automatically
					'name' => 'VARCHAR(25) NOT NULL',	// key = column name, value = valid MySQL table initialisation string
					'type' => 'VARCHAR(15) NOT NULL',
					'cost' => 'DECIMAL(11,2) DEFAULT 0',
					'secretNotes' => 'TEXT',
					'description' => 'VARCHAR(125) NOT NULL'
				),
				'admin' => array(
					'label' => 'Rating Categories',			// this is used for the admin menu item text
					'singular' => 'Rating Category',		// this and title are used automatically to identify this element
					'title' => 'Rating Categories',			// Title shown at tope of admin page. This and singular are used automatically to identify this element (this one is plural/collective)
					'slug' => 'rating_categories',			// Used to identify this table internally. Must be unique.
					'import' => true,						// Allow CSV data imports? YES = true, default = false (no imports) - still in beta!!
					'cols' => array(						// List the columns that will be displayed in the List Table, 'edit' and 'Add New' screens.
						'name' => array(
							'label' => 'Category Name'		// Adding a label adds this column to the admin screen List Table.
															// The label is also used on the 'edit' and 'Add New' screens. Without a label, those screens show the column name.
															// If you want a nice label for those screens, but not have this column in the List Table, add the column to the 'hidden' array below.
						),
						'type' => array(
							'label' => 'Rating Type',
							'options' => array( '5 star' ),	// Edit and Add New screen will present this array as a drop down for selecting a valid value
							'separator' => true				// Draw a separator after this field on the 'edit' and 'Add New' screens. Helps to break up the data on those screens.
						),
						'cost' => array(
							'label' => 'Cost',
							'prefix' => '$',				// Displays this on the 'edit' and 'Add New' screens immediately BEFORE the field
							'suffix' => 'USD',				// Displays this on the 'edit' and 'Add New' screens immediately AFTER the field
						),
						'description' => array(
							'label' => 'Description'
						)
					),
					'list_table' => array(					// An array of options for the List Table
						'include_modified'	=> true,		// Include the last_modified column in the List Table? true is the default
						'bulk_actions'	=> array(			// Adding bulk actions automatically adds the drop down and the cb column
							'delete' => 'Delete'
						),
						'actions' => array(					// Add any specific actions to a column. These appear under each value in the column
															// Any column called 'name' will automcatically have "edit" and "delete" actions added.
															// You can add 'edit' and 'delete' as slugs below on any column with unique values
							'type' => array(				// Use the column name as the key for the array of actions. Each action is then another array.
								array(
									'slug' => 'filtercol',		// 'filtercol' is handled by the class and filters the data to only those rows where this column is equal to this value
									'label' => 'Filter'			// This is the text that will appear beneath each value in the column
								),
								array(
									'slug' => 'unfiltercol',	// 'unfiltercol' is handled by the class and removes all filters
									'label' => 'Unfilter'		// This is the text that will appear beneath each value in the column
								) 
							)
						),
						'sortable' => array( 'name', 'type' ),	// sortable columns (modified is already included if include_modified is set)
						'hidden' => array( 'secretNotes' )		// Hide these columns in the List Table
					)
				)
			)

 *	
**/

/**
 *	Hide admin toolbar
 *
 *	One of the bugbears of WordPress is the presence of the admin bar across the top of your site.
 *	Now you can get rid of it for ALL users (including admin) on the front of your site (not from the admin side):
 *
 *	$myplugin->hideAdminToolbar();
 *
 *	You can call this method from anywhere, but you may decide that overriding the class initialise() method is best:

		public function initialise() {
			$this->hideAdminToolbar();
		}
 
**/


/**
 *	Changes to v0.04
 *	Added admin menu and ajax docs		// Added documentation and examples to better explain admin menus and ajax
 *	Fixed List Table filter bug			// Fixed a bug where the list table would not filter on a column
 *	Added CSV import					// Added support to import CSV file data into custom db
 *	Added new DB display options		// Added to edit/new screen: separators, prefix, suffix, DECIMAL field type
 *	Added hidden columns				// Added support for hidden columns in List Tables
 *	Added Critical Content				// A system to retrieve Critical Data from another url for security reasons. No documentation as yet.
 *	Added hideAdminToolbar()			// Hides the admin toolbar on the front end, either for all users or just non-admins
 *	Added support for WP List Tables	// Added initial and limited support to ease the use of WP_List_Table class
 *	Added support for custom tables		// Added support to create custom MySQL tables with support for writing and reading data (Dec 2018)
 *	Meta box bugfix						// Fixed bug where checkbox (boolean) meta data was not being saved if checkbox was not selected
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
		public $class_version	= 004;		// Version number of the october-plugin-class
		public $version			= 001;		// Version number of the subclass
		public $copyright		= '';		// Copyright notice
		public $slug 			= '';		// This slug is used as the short name for the plugin. Must be unique.
		public $js_slug			= '';		// The same slug, but sanitised for javascript, databases, etc (ie, dashes/dots change to underscore, etc)
		public $file_base		= '';		// full path to plugin file (including filename)
		public $class_base		= '';		// full path to class file (including filename)
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
		public $custom_db = null;			// Array of arrays, one for each custom database table
		public $list_table = null;			// A WP_List_Table. Has to be created outside of this plugin, but can then be assigned here
		public $debug = false;				// false = no debugging info, true = echo debugging info (eg, _POST, _GET) to screens
		
		
		private $methods = array();			// Private array of dynamically created methods. The following methods create new methods dynamically:
											// make_db_menu()
		


		/**
		 *	Construct the plugin class object
		 * 
		 *	slug = Shortname for the plugin. Must be unique. (Required for full functionality)
		 *	args = array of arguments. (Optional)
		**/
		public function __construct( $slug = null ) {
			if( null !== $slug ) {
				$this->slug = $slug;
				// sanitise the slug
				$this->js_slug = preg_replace( "/[^a-zA-Z0-9]/", "_", $slug );
				$this->file_base = plugin_dir_path( dirname( __FILE__ ) ).$this->slug.'.php';
				$this->class_base = plugin_dir_path( dirname( __FILE__ ) ).'october-plugin-class.php';
				// this one is for debugging only - comment out when not required!!
//				add_action( 'all', create_function( '', 'var_dump( current_filter());' ) );
				// register actions for WordPress
				add_action( 'wp_ajax_nopriv_'.$slug, array( &$this, 'do_ajax' ) );
				add_action( 'wp_ajax_'.$slug, array( &$this, 'do_ajax' ) );
				add_action( 'wp_enqueue_scripts', array( &$this,'do_enqueues' ) );
				add_action( 'admin_enqueue_scripts', array( &$this,'do_admin_enqueues' ) );
				add_action( 'admin_menu', array( &$this, 'add_admin_menus' ) );
				add_action( 'admin_menu', array( &$this, 'make_db_menu' ) );
				add_action( 'init', array(&$this, 'create_custom_post_types') );
				add_action( 'init', array(&$this, 'create_custom_taxonomies') );
				add_action( 'init', array(&$this, 'initialise') );
				add_action( 'admin_init', array(&$this, 'include_custom_fields') );
				// Add a shortcode
				add_shortcode( $this->slug, array(&$this, 'do_shortcode') );
				$this->initialise();
			}
		} // END public function __contruct()
		
		/**
		 *	Allow for dynamically created class methods. The following methods create new methods dynamically:
		 *	make_db_menu()
		**/
		function __call( $method, $args ) {
			if( is_callable( $this->methods[ $method ] ) ) {
				return call_user_func_array( $this->methods[ $method ], $args );
			}
		}		

		
		/**
		 *	Write text to the default plugin output log
		 *	(This is a static function, so can be called without instantiating the class. eg october_plugin::slog(), or my_instance::slog() )
		 * 
		 *	errtext = Text string to be written (Optional)
		**/	
		public static function slog( $errtext = null ) {
				$errdate = current_time( 'D jS M Y h:i:s A' );
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
		 *	Turn off the admin toolbar on the front end
		 *	Either for all users, or only for non-admins
		 *	flag = 'all' (default) to remove for all users, or 'nonadmins' to remove only for non admins
		**/
		public function hideAdminToolbar( $flag = 'all' ) {
			if( 'nonadmins' === $flag ) {
				if ( ! current_user_can( 'manage_options' ) ) {
					show_admin_bar( false );
				}				
			} else {
				show_admin_bar( false );
			}
		}
		
		
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
		 *
		 *	WP_LIST_TABLES
		 *
		 *	These functions aim to simplify the use of WP_List_Tables
		 *	Most of these methods assume that the WP_List_Table is being used to render data 
		 *	from a Custom Database Table to the admin screen (these are prefixed with db_)
		 *
		**/

		// Create an array of columns for a List Table. 
		// Useful for the array required by WP_List_Table::get_columns()
		public function db_lt_columns( $table_name ) {
			$this->log( 3, "db_lt_columns() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$columns = array();
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'bulk_actions', $current[ 'admin' ][ 'list_table' ] ) ) {
					$columns[ 'cb' ] = '<input type="checkbox" />';
				}
				foreach( $current[ 'admin' ][ 'cols' ] as $column => $data ) {
					if( array_key_exists( 'list', $data ) && $data[ 'list' ] == false ) {
						// user does not want this included in the list table
					} else {
						// user has asked for this to be included (or we are defaulting to true)
						$columns[ $column ] = $data[ 'label' ];
					}
				}
				if( array_key_exists( 'include_modified', $current[ 'admin' ][ 'list_table' ] ) ) {
					$columns[ 'modified' ] = "Last Modified";
				}
				$this->log( 3, "db_lt_columns() columns = ".print_r( $columns, true ) );
				return $columns;
			}
			return null;
		}

		// Create an array of sortable columns for a List Table. 
		// Useful for the array required by WP_List_Table::get_sortable_columns()
		public function db_lt_sortable_columns( $table_name ) {
			$this->log( 3, "db_lt_sortable_columns() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$columns = array();
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'sortable', $current[ 'admin' ][ 'list_table' ] ) ) {
					foreach( $current[ 'admin' ]['list_table'][ 'sortable' ] as $col ) {
						$columns[ $col ] = array( $col, false );
					}
					if( array_key_exists( 'include_modified', $current[ 'admin' ][ 'list_table' ] ) ) {
						$columns[ 'modified' ] = array( 'modified', false );
					}
				}
				$this->log( 3, "db_lt_sortable_columns() columns = ".print_r( $columns, true ) );
				return $columns;
			}
			return null;
		}
		
		// Create an array of hidden columns for a List Table. 
		public function db_lt_hidden_columns( $table_name ) {
			$this->log( 3, "db_lt_hidden_columns() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'hidden', $current[ 'admin' ][ 'list_table' ] ) ) {
					$this->log( 3, "db_lt_hidden_columns() columns = ".print_r( $columns, true ) );
					return $current[ 'admin' ][ 'list_table' ][ 'hidden' ];
				} else {
					return array();
				}
			}
			return null;
		}
		
		// Create an array of bulk actions for a List Table. 
		// Useful for the array required by WP_List_Table::get_bulk_actions()
		public function db_lt_bulk_actions( $table_name ) {
			$this->log( 3, "db_lt_bulk_actions() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$columns = array();
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'bulk_actions', $current[ 'admin' ][ 'list_table' ] ) ) {
					foreach( $current[ 'admin' ][ 'list_table' ][ 'bulk_actions' ] as $column => $label ) {
						$columns[ $column ] = $label;
					}
				}
				$this->log( 3, "db_lt_bulk_actions() columns = ".print_r( $columns, true ) );
				return $columns;
			}
			return null;
		}
		
		// Create an array of column actions for a List Table
		public function db_lt_column_actions( $table_name ) {
			$this->log( 3, "db_lt_column_actions() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$actions = array();
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'actions', $current[ 'admin' ][ 'list_table' ] ) ) {
					foreach( $current[ 'admin' ][ 'list_table' ][ 'actions' ] as $action => $data ) {
						$actions[ $action ] = $data;
					}
				}
				return $actions;
			}
			return null;
		}
		
		// Create an array of filters for a List Table
		public function db_lt_filters( $table_name ) {
			$this->log( 3, "db_lt_filters() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$filters = array();
			if( null !== $current ) {
				if( array_key_exists( 'list_table', $current[ 'admin' ] ) && array_key_exists( 'filters', $current[ 'admin' ][ 'list_table' ] ) ) {
					foreach( $current[ 'admin' ][ 'list_table' ][ 'filters' ] as $filter => $data ) {
						$filters[ $filter ] = $data;
					}
				}
				return ( ! empty( $filters ) ) ? $filters : null;
			}
			return null;
		}
		
		// Create an array of custom displays for a List Table
		public function db_lt_custom_displays( $table_name ) {
			$this->log( 3, "db_lt_custom_displays() started. table name = ".$table_name );
			$current = $this->get_table_array( $table_name );
			$displays = array();
			if( null !== $current ) {
				if( array_key_exists( 'cols', $current[ 'admin' ] ) ) {
					foreach( $current[ 'admin' ][ 'cols' ] as $col => $data ) {
						if( array_key_exists( 'display', $data ) ) {
							$displays[ $col ] = $data[ 'display' ];
						}
					}
				}
				return $displays;
			}
			return null;
		}
		
		// Initialise a list table with everything for a custom database table
		public function db_lt_init( $name ) {
			$this->log( 3, "db_lt_init() Started. name = ".$name );
			$this->list_table->columns =  $this->db_lt_columns( $name );
			$this->list_table->sortable =  $this->db_lt_sortable_columns( $name );
			$this->list_table->hidden = $this->db_lt_hidden_columns( $name );
			$this->list_table->bulk_actions =  $this->db_lt_bulk_actions( $name );			
			$this->list_table->actions =  $this->db_lt_column_actions( $name );			
			$this->list_table->filters =  $this->db_lt_filters( $name );	
			$this->list_table->custom_displays = $this->db_lt_custom_displays( $name );
		}
		
		// Display a list table created for a custom database table
		public function db_lt_display( $name ) {
			$this->log( 2, "db_lt_display() Started. table name = ".$name );
			$current = $this->get_table_array( $name );
			echo '<div class="wrap"><h2>'.$current[ 'admin' ][ 'title' ].'</h2>'; 

			// retrieve any 'orderby' from the _GET array
			$orderby = null;
			if( array_key_exists( 'orderby', $_GET ) ) {
				$orderby = $_GET[ 'orderby' ].' '.$_GET[ 'order' ];
				// this means someone clicked on the header of a sortable item.
				// blank out the 'action' key in the _GET array, just in case it is still hanging around
//				unset( $_GET[ 'action' ] );
			}
			$this->log( 2, "db_lt_display() orderby = ".$orderby );
			
			// retrieve any filters from the _GET array
			// these are used if a filter has been set up on one of the columns in the List Table using actions. Eg:
			// 'actions' => array(
			//		'client' => array(				// an array for each action for this column 
			//			array(
			//				'slug' => 'filter',		// 'filter' is handled by the class
			//				'label' => 'Show Only'
			//			) 
			//		)
			//	)	
			$where = null;
			if( array_key_exists( 'action', $_GET ) && 'filtercol' == $_GET[ 'action' ] ) {
				$this->log( 3, "db_lt_display() got action=filtercol " );
				if( array_key_exists( 'col', $_GET ) && array_key_exists( 'val', $_GET ) ) {
					if( is_numeric( $_GET[ 'val' ] ) ) {
						$where = $_GET[ 'col' ]." = ".$_GET[ 'val' ];					
					} else {
						$where = $_GET[ 'col' ]." = '".$_GET[ 'val' ]."'";					
					}
				}
			}
			if( array_key_exists( 'action', $_GET ) && 'unfiltercol' == $_GET[ 'action' ] ) {
				$this->log( 3, "db_lt_display() got action=unfiltercol " );
			}
			// retrieve any filters from the _POST array
			// these are used if a filter has been set up on the extra_nav part of the List Table. Eg:
			// 'filters' => array(
			//		'archived' => array(						// key = column on which filter will occur
			//			'Archived and unarchived' => null,		// key = label for option, value = value to filter by (or null = no filter)
			//			'Only show unarchived' => 0,
			//			'Only show archived' => 1
			//		)
			//	) 
			if( array_key_exists( 'filters', $current[ 'admin' ][ 'list_table' ] ) ) {
				$this->log( 2, "db_lt_display() This table includes extra_nav filters." );
				foreach( $current[ 'admin' ][ 'list_table' ][ 'filters' ] as $col => $data ) {
					$this->log( 3, "db_lt_display() Check _POST for filter_".$col );
					if( array_key_exists( 'filter_'.$col, $_POST) && "" !== $_POST[ 'filter_'.$col ] ) {
						$this->log( 3, "db_lt_display() filter_".$col." IS present in _POST" );
						if( strlen( $where) > 0 ) {
							$where .= " AND ";
						}
						$where .= $col." = ".$_POST[ 'filter_'.$col ];
					}
				}
			}

			$this->log( 2, "db_lt_display() where = ".$where );

			// add an Add New button
			$addButton = sprintf('<a href="?page=%s&action=%s" class="button button-secondary" style="margin-right: 3em;">Add New '.$current[ 'admin' ][ 'singular' ].'</a>',$_REQUEST['page'],'new');
			echo $addButton;
			
			// add an Import CSV button
			$doImport = ( array_key_exists( 'import', $current[ 'admin' ] ) ) ? $current[ 'admin' ][ 'import' ] : false;
			if( $doImport ) {
				$importButton = sprintf('<a href="?page=%s&action=%s" class="button button-secondary" style="margin-right: 3em;">Import CSV data</a>',$_REQUEST['page'],'import');
				echo $importButton;
			}
			
			// Create and display the List Table
			$this->list_table = new octo_list_table();
			$this->db_lt_init( $name );
			$this->list_table->data = $this->db_get( $name, $where, $orderby );
			$this->list_table->prepare_items(); 
			echo sprintf('<form id="db_list_form" method="post" action="?page=%s">', $_REQUEST['page'] );
			$this->list_table->display(); 
			echo '</form></div>'; 		
		}
		
		// Perform default bulk actions. Actions currently supported:
		// 1. delete
		public function db_lt_doDefaultBulkActions( $name ) {
			$this->log( 3, "db_lt_doDefaultBulkActions() Started. name = ".$name );
			$current = $this->get_table_array( $name );
			
			// look for BULK actions to be performed (from the bulk actions drop-down at top and bottom of the list table)
			// Bulk actions can be detected by looking for both 'action' and 'action2' in the POST data
			// 'action' is the top button, 'action2' is the bottom button
			if( array_key_exists( 'action', $_POST ) && array_key_exists( 'action2', $_POST ) ) {
				$bulkAction = ( '-1' == $_POST[ 'action' ] ) ? $_POST[ 'action2' ] : $_POST[ 'action' ];
				$this->log( 2, "db_lt_doDefaultBulkActions() bulkAction = ".$bulkAction );
				switch( $bulkAction ) {
					case 'delete':
						$count = 0;
						if( array_key_exists( 'cat', $_POST ) ) {
							foreach( $_POST[ 'cat' ] as $cat ) {
								$result = $this->db_delete( $current[ 'name' ], $cat );
								if( $result > 0 ) {
//									echo '<div class="updated notice"><p>The selected '.$current[ 'admin' ][ 'singular' ].' was successfully deleted.</p></div>';
									$count++;
								} else {
									echo '<div class="error notice"><p>Something went wrong. One of the selected '.$current[ 'admin' ][ 'title' ].' was NOT deleted.</p></div>';
								}
							}
							if( $count > 0 ) {
								echo '<div class="updated notice"><p>'.$count.' '.$current[ 'admin' ][ 'title' ].' successfully deleted.</p></div>';
							} else {
								echo '<div class="error notice"><p>Something went wrong.</p></div>';
							}
						} else {
							echo '<div class="error notice"><p>Error. No '.$current[ 'admin' ][ 'title' ].' were selected to be deleted.</p></div>';							
						}
						break;
					default:
						echo '<div class="error notice"><p>Error. No valid Bulk Action selected.</p></div>';							
				}
			}
			
		} // END function db_lt_doBulkActions() 
		
		// Check to see if the current form matches any known BOOLEAN types so that we can save/update unchecked ones
		public function db_include_unset_checkboxes( $table, $data ) {
			$this->log( 3, "db_include_unset_checkboxes() Started." );
			// loop through the table data to see if any BOOLEANS are in there
			if( array_key_exists( 'cols', $table ) ) {
				foreach( $table[ 'cols' ] as $name => $sql ) {
					$char = strpos( $sql, 'BOOLEAN' );
					$this->log( 3, "db_include_unset_checkboxes() Looking for BOOLEAN, sql = ".$sql.", char = ".$char );
					if( ( false !== $char ) && ( 0 == $char ) ) {
						// found a BOOLEAN
						if( ! array_key_exists( $name, $data ) ) {
							$data[ $name ] = 0;
						}
					}
				}
			}
			return $data;
		}
		
		// Perform default actions. Actions currently supported:
		// 1. edit		(show an edit screen for an existing database row)
		// 2. new		(show a new record screen to enter details for a new database row)
		// 3. save		(save a new database row)
		// 4. update	(update an existing database row)
		// 5. delete	(delete a single existing database row)
		public function db_lt_doDefaultActions( $name ) {
			$this->log( 3, "db_lt_doDefaultActions() Started. name = ".$name );
			$current = $this->get_table_array( $name );
			$returnFlag = true;
			
			// Look for actions to be performed
			// (but only if 'orderby' doesn't also exist - that means someone is just reordering the list using a sortable column header)
			if( array_key_exists( 'action', $_GET ) && ! array_key_exists( 'orderby', $_GET ) ) {
				$this->log( 2, "db_lt_doDefaultActions() Found an action. action = ".$_GET[ 'action' ] );
				switch( $_GET[ 'action' ] ) {
					case 'edit':
						$this->display_db_edit( $current, 'edit', $_GET[ 'cat' ] );
						$returnFlag = false;
						break;
					case 'new':
						$this->display_db_edit( $current, 'new' );
						$returnFlag = false;
						break;
					case 'save':
						unset( $_POST[ 'table' ] );
						unset( $_POST[ 'id' ] );
						$_POST = $this->db_include_unset_checkboxes( $current, $_POST );
						$result = $this->db_insert( $current[ 'name' ], $_POST );
						if( $result > 0 ) {
							echo '<div class="updated notice"><p>Your new '.$current[ 'admin' ][ 'singular' ].' was successfully saved.</p></div>';
						} else {
							echo '<div class="error notice"><p>Something went wrong. Your new '.$current[ 'admin' ][ 'singular' ].' was NOT saved.</p></div>';
						}
						break;
					case 'update':
						$id = $_POST[ 'id' ];
						unset( $_POST[ 'table' ] );
						unset( $_POST[ 'id' ] );
						$_POST = $this->db_include_unset_checkboxes( $current, $_POST );
						$result = $this->db_update( $current[ 'name' ], $id, $_POST );
						if( $result > 0 ) {
							echo '<div class="updated notice"><p>The '.$current[ 'admin' ][ 'singular' ].' was successfully updated.</p></div>';
						} else {
							echo '<div class="error notice"><p>Something went wrong. The '.$current[ 'admin' ][ 'singular' ].' was NOT updated.</p></div>';
						}
						break;
					case 'delete':
						$result = $this->db_delete( $current[ 'name' ], $_GET[ 'cat' ]);
						if( $result > 0 ) {
							echo '<div class="updated notice"><p>The selected '.$current[ 'admin' ][ 'singular' ].' was successfully deleted.</p></div>';
						} else {
							echo '<div class="error notice"><p>Something went wrong. The '.$current[ 'admin' ][ 'singular' ].' was NOT deleted.</p></div>';
						}
						break;
					case 'import':
						if( ! array_key_exists( 'file', $_FILES ) ) {
							echo '<div class="wrap"><h2>Import CSV data to table "'.$current[ 'name' ].'"</h2>'; 
							echo '<form enctype="multipart/form-data" method="post">';
							echo '<br />Please select the comma-delimited CSV file to upload. (Remember: the first line of the CSV file *must* contain field names that correspond to the saved table.)<br /><br />';
							echo '<input type="file" name="file">';
							echo '<input type="hidden" name="action" value="import">';
							echo '<input type="hidden" name="page" value="'.$current[ 'admin' ][ 'slug' ].'">';
							echo '<input type="submit" name="request" value="Commence Import" class="button button-primary" style="margin: 0px 2em;">';
							echo '<input type="submit" name="request" value="Cancel" class="button button-secondary" style="margin: 0px 2em;">';
							echo '</form>';
							echo '</div>';
							$returnFlag = false;
						} else {
							if( array_key_exists( 'request', $_POST ) && $_POST[ 'request' ] != 'Cancel' ) {
								if( array_key_exists( 'type', $_FILES[ 'file' ] ) && strlen( $_FILES[ 'file' ][ 'type' ] ) == 0 ) {
									echo '<div class="error notice"><p>No file selected.</p></div>';
								} else {
									if( $_FILES[ 'file' ][ 'type' ] != 'text/csv' )  {
										echo '<div class="error notice"><p>Incorrect filetype "'.$_FILES[ 'file' ][ 'type' ].'". Must be CSV.</p></div>';
									} else {

										// A valid CSV file has been uploaded. Begin import.
								
										$filename = $_FILES[ "file" ][ "tmp_name" ];
										$linecount = 0;
										$fieldnames = null;
										if( $_FILES[ "file" ][ "size" ] > 0 ) {
											$file = fopen( $filename, "r" );
											while( ( $getData = fgetcsv( $file, 0, ",") ) !== FALSE ) {
												if( $linecount == 0 ) {
													$fieldnames = $getData;
												} else {
													$dataArray = null;
													$fieldCount = 0;
													foreach( $fieldnames as $field ) {
														$dataArray[ $field ] = $getData[ $fieldCount ];
														$fieldCount++;
													}
													$result = $this->db_insert( $current[ 'name' ], $dataArray );
													if( $result == false ) {
														echo '<div class="error notice"><p>There was an error saving row '.$linecount.'. '.$this->db_last_error.'</p></div>';																	
//														break;
													}
//													echo "Read a line from CSV. Count = ".$linecount.", field count = ".$fieldCount.", result = ".$result."<br />\n";
												}
												$linecount++;
											}
											fclose( $file );
											echo '<div class="updated notice"><p>Imported '.$linecount.' rows of data. '.$this->db_last_error.'</p></div>';																	
										} else { 
											echo '<div class="error notice"><p>Your CSV file contained no data.</p></div>';									
										}	 // END of if()	
										
									} // END of else{}
								} // END of else{}								
							} else {
								echo '<div class="notice-warning notice"><p>Import cancelled.</p></div>';
							}					
						}
						break;
					case 'filtercol':
						echo '<div class="updated notice"><p>Now filtering on column '.$_GET[ 'col' ].'</p></div>';
						break;
					case 'unfiltercol';
						// this action is handled in db_lt_display(), but we have to add here to avoid the error msg
						break;
					default:
						echo '<div class="error notice"><p>Unknown action. ['.$_GET[ 'action' ].']</p></div>';
				}			
			}
			
			return $returnFlag;
		} // END function db_lt_doDefaultActions()
		
		// Handle the admin menu requirements for a custom database table
		public function db_handleAdminMenu( $name = null ) {
			$this->log( 3, "db_handleAdminMenu() started. name = ".$name );
			if( true == $this->debug ) {
				$this->echo_get( true );
				$this->echo_post( true );
				$this->echo_files( true );
			}
			
			if( null !== $name ) {
				// First, manage any default actions passed in the _GET array
				$doList = $this->db_lt_doDefaultActions( $name );
					
				// Next, manage any default bulk actions passed in the _POST array
				$this->db_lt_doDefaultBulkActions( $name );
			
				// If required, display the table data in a WP List Table
				if( true == $doList) {
					$this->db_lt_display( $name );
				}
			}
		}
		
		
		
		
		
		
		
		/**
		 *
		 *	CUSTOM DATABASE TABLES
		 *
		 *	Functionality to easily build, write and read custom database tables
		 *
		**/
		
		// return a full, valid WP table name for the given table array
		public function db_tablename( $table ) {
			global $wpdb;
			return $wpdb->prefix.$this->slug.'_'.$table['name'];
		}
		
		// return the definition array for a given table name
		public function get_table_array( $name ) {
			$result = null;
			if( null !== $this->custom_db ) {
				foreach( $this->custom_db as $table ) {
					if( 'array' == gettype( $table ) ) {
						if( array_key_exists( 'name', $table ) && $table[ 'name' ] == $name ) {
							$result = $table;
						}
					} // end of if( 'array' )
				}
			}
			return $result;
		}
		
		public function create_db_table( $table ) {
//			$this->log( 1, "create_db_table() started. table = ".print_r( $table, true ) );
			$this->log( 2, "create_db_table() started." );
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();
			$table_name = $wpdb->prefix.$this->js_slug.'_'.$table['name'];
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) UNSIGNED NOT NULL AUTO_INCREMENT,
				created timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
				modified timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL";
			foreach( $table['cols'] as $col => $val ) {
				$this->log( 3, "create_db_table() add in ".$col." => ".$val );
				$sql .= ",\n\t\t$col $val";
			}
			$sql .= ",\n\t\tUNIQUE KEY id (id)\n) $charset_collate;";
			$this->log( 2, "create_db_table() sql = ".$sql );
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$result = dbDelta( $sql );
			$this->log( 2, "create_db_table() result = ".print_r( $result, true ) );
		}
		
		public function check_db_tables() {
			$this->log( 2, "check_db_tables() started." );
			
			// Check for any custom_db entries
			if( null !== $this->custom_db ) {
				$this->log( 2, "check_db_tables() custom_db is NOT null" );
				global $wpdb;
				
				// we have custom_db entries, so loop through them 
				foreach( $this->custom_db as $table ) {
					$this->log( 3, "check_db_tables() loop on ".print_r( $table, true ) );
					
					if( 'array' == gettype( $table ) ) {
						
						$table_name = $this->db_tablename( $table );
					
						// First, check if the table exists. If not, create it
						$this->log( 3, "check_db_tables() checking ".$table_name );
						if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name ) {
							$this->log( 2, "check_db_tables() table ".$table_name." not found." );
							$this->create_db_table( $table );
//							if( array_key_exists( 'init', $table ) ) { // this was an idea I had about setting initial data
//								foreach( $table['init'] as $row ) {
//								}
//							}
						} else {
							$this->log( 2, "check_db_tables() table ".$table_name." found. Now check the version?" );
						}
					} // end of if( 'array' )
					
				} // end of foreach()
			}
		}
		
		//	Create an admin menu and submenus for any database used
		//	(Called during admin_menu hook)
		public function make_db_menu() {
			$this->log( 3, "make_db_menu() started." );
			$menuRequired = false;

			// Check for any custom_db entries
			if( null !== $this->custom_db ) {
				$this->log( 3, "make_db_menu() custom_db is not null." );

				// we have db items. Loop through them looking for menu requirements
				$menuRequired = false;
				foreach( $this->custom_db as $table ) {

					if( 'array' == gettype( $table ) ) {
						if( array_key_exists( 'admin', $table ) ) {
							// yes, this one needs a menu, so set the flag
							$this->log( 3, "make_db_menu() custom_db table needs an admin menu" );
							$menuRequired = true;
						}
					} // end of if( 'array' )
				}
			}
			
			if( $menuRequired ) {
				// an admin menu is required for the database. Add it.
				$this->log( 2, "make_db_menu() Menu is required - create it." );
				$pageTitle = ( array_key_exists( 'pageTitle' , $this->custom_db ) ) ? $this->custom_db[ 'pageTitle' ] : "oDatabase page" ;
				$menuName = ( array_key_exists( 'menuName' , $this->custom_db ) ) ? $this->custom_db[ 'menuName' ] : "oDatabase";
				add_menu_page(
					$pageTitle,
					$menuName,
					"manage_options",
					"odatabase_menu", 
					null, // if this callback is null, it defaults to submenu 0, which is a good thing
					'dashicons-networking',
					30
				);
				
				// add the required submenus
				foreach( $this->custom_db as $table ) {
					if( 'array' == gettype( $table ) ) {

						if( array_key_exists( 'admin', $table ) ) {
							// yes, this one needs a menu
							$this->log( 2, "make_db_menu() custom_db table needs a submenu" );						
							$admin = $table[ 'admin' ];
	
							// if the user defined their own callback method, use that. 
							// Otherwise, dynamically create one
							$callbackName = ( array_key_exists( 'callback', $admin ) ) ? $admin[ 'callback' ] : "db_menu_".$admin[ 'slug' ];
							if( ! is_callable( $callbackName ) ) {
								$this->log( 2, "make_db_menu() the callback '".$callbackName."' does not exist. Create it." ); 
								$callbackFunc = function() use( $callbackName, $table ) {
									$this->log( 2, $callbackName."() [dynamically created callback] started." );
									$this->db_handleAdminMenu( $table[ 'name' ] );				
								};
								$this->methods[ $callbackName ] = \Closure::bind( $callbackFunc, $this, get_class() );
							} 

							add_submenu_page(
								"odatabase_menu",
								$admin[ 'label' ],
								$admin[ 'label' ],
								"manage_options",
								$admin[ 'slug' ],
								array( &$this, $callbackName )
							);
						} // end of if( array_key_exists() )
						
					} // end of if( 'array' )
				}
				// WordPress adds a submenu to Admin menus identical to the main menu item. Remove it.
				remove_submenu_page( "odatabase_menu", "odatabase_menu" );
				
				// Load in the List Table class in preparation for building the menu pages
//				$this->log( 2, "make_db_menu() Check for WP_List_Table." );
//				if( ! class_exists( 'WP_List_Table' ) ) {
//					$this->log( 3, "make_db_menu() Not found. Load WP_List_Table." );
//					require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
//				} else {
//					$this->log( 3, "make_db_menu() WP_List_Table was found already." );
//				}
			} 
			
		}
		
		// get the data from a table
		// $table can either be the name of the table, or the array from this object
		public function db_get( $table, $where = null, $orderby = null ) {
			$this->log( 2, "db_get() started." );
			$table_array = ( 'string' == gettype( $table) ) ? $this->get_table_array( $table ) : $table;
			$table_name = $this->db_tablename( $table_array );
			$this->log( 3, "db_get() get data from table ".$table_name );
			global $wpdb;
			$wpdb->show_errors();
			$sql = "SELECT * FROM ".$table_name;
			$sql .= ( null !== $where ) ? " WHERE ".$where : " ";
			$sql .= ( null !== $orderby ) ? " ORDER BY ".$orderby : " ORDER BY modified DESC ";
			$this->log( 2, "db_get() sql = ".$sql );
			$result = $wpdb->get_results( $sql );
//			$this->log( 3, "db_get() result = ".print_r( $result, true) );
			$array = json_decode( json_encode( $result ), true );
			$this->log( 3, "db_get() result = ".print_r( $array, true) );
			$wpdb->hide_errors();
			return $array;
		}
		
		
		// insert a new row
		// $table can either be the name of the table, or the array from this object
		// $data is a hash array of col => value pairs
		public function db_insert( $table, $data ) {
			$this->log( 3, "db_insert() started." );
			$table_array = ( 'string' == gettype( $table) ) ? $this->get_table_array( $table ) : $table;
			$table_name = $this->db_tablename( $table_array );
			// save a row of data to the given table
			$this->log( 2, "db_insert() add a row to table ".$table_name );
//			$this->log( 3, "db_insert() row data = ".print_r( $data, true ) );
			global $wpdb;
			$wpdb->show_errors();
			$result = $wpdb->insert( $table_name, $data );
			$this->db_last_query = $wpdb->last_query;
			$this->db_last_error = $wpdb->last_error;
//			$wpdb->print_error();
			$wpdb->hide_errors();
			$this->log( 1, "db_insert() last query = ".$wpdb->last_query );
			$this->log( 1, "db_insert() last error = ".$wpdb->last_error );
			$this->log( 3, "db_insert() result of insert = ".$result );
			return $result;
		}
		

		// update an existing row
		// $table can either be the name of the table, or the array from this object
		// $id is the id of the row to be updated
		// $data is a hash array of col => value pairs
		public function db_update( $table, $id, $data ) {
			$this->log( 2, "db_update() started." );
			$table_array = ( 'string' == gettype( $table) ) ? $this->get_table_array( $table ) : $table;
			$table_name = $this->db_tablename( $table_array );
			// update a row of data to the given table
			$this->log( 2, "db_update() update row in table ".$table_name );
			$this->log( 3, "db_update() row data = ".print_r( $data, true ) );
			global $wpdb;
			$wpdb->show_errors();
			$result = $wpdb->update( $table_name, $data, array( 'id' => intval( $id )  ) );
//			$this->log( 1, "db_update() var_dump = ". var_dump( $wpdb->last_query ) );	
			$wpdb->hide_errors();
			$this->log( 2, "db_update() result of update = ".$result );
			return $result;
		}
		

		// delete a row
		// $table can either be the name of the table, or the array from this object
		public function db_delete( $table, $id ) {
			$this->log( 2, "db_delete() started." );
			$table_array = ( 'string' == gettype( $table) ) ? $this->get_table_array( $table ) : $table;
			$table_name = $this->db_tablename( $table_array );
			// delete the row
			$this->log( 3, "db_delete() delete id=".$id." from table ".$table_name );
			global $wpdb;
			$wpdb->show_errors();
			$result = $wpdb->delete( $table_name, array( 'id' => $id ) );
			$wpdb->hide_errors();
			$this->log( 2, "db_delete() result of delete = ".$result );
			return $result;
		}
		
		// display the edit page for a table (used for both new and edit)
		// $current = current table data, $action = new or edit, $id = id of table row if action == edit
		public function display_db_edit( $current, $action, $id = 0 ) {
			$this->log( 3, "display_db_edit() started. action = ".$action );
			$title = ( 'new' == $action ) ? 'Add New '.$current['admin']['singular'] : 'Edit Existing '.$current['admin']['singular'];
			$currentData = ( 'new' == $action ) ? null : $this->db_get( $current[ 'name' ], 'id = '.$id );
			$formAction = ( 'new' == $action ) ? 'save' : 'update';
			echo '<div class="wrap"><h2>'.$title.'</h2><p>&nbsp;</p>'; 
			echo sprintf(' <div style="width: 100%%;"><form id="db_edit_form" method="post" action="?page=%s&action=%s">', $_REQUEST['page'], $formAction );
			
			// Loop through each col provided in the class property for this $current table
			foreach( $current[ 'cols' ] as $key => $value ) {
				
				// Check to see if there is any data provided in admin for us to use
				$colData = null;
				$label = $key;
				if( array_key_exists( 'cols', $current[ 'admin' ] )  && array_key_exists( $key, $current[ 'admin' ][ 'cols' ] ) ) {
					$colData = $current[ 'admin' ][ 'cols' ][ $key ];
					$label = $colData[ 'label' ];
				}

				$editable = true;
				$hidden = false;
				$sep = false;
				$prefix = '';
				$suffix = '';
				if( null !== $colData ) {
					// If this col should be hidden, don't display it
					$editable = ( array_key_exists( 'editable', $colData ) ) ? $colData[ 'editable'] : true;
					$hidden = ( array_key_exists( 'hidden', $colData ) ) ? $colData[ 'hidden'] : false;
					$hidden = ( ( $editable == false ) && ( $formAction == 'save' ) ) ? true : $hidden; // hide if not editable and this is new
					$sep = ( array_key_exists( 'separator', $colData ) ) ? $colData[ 'separator'] : false; // add a separator after this field. default = false
					$prefix = ( array_key_exists( 'prefix', $colData ) ) ? $colData[ 'prefix'] : ''; // Print something to the left of the data field. default = null
					$suffix = ( array_key_exists( 'suffix', $colData ) ) ? $colData[ 'suffix'] : ''; // Print something to the right of the data field. default = null
				}
				
				if( false == $hidden ) {
					// This column isn't hidden for the edit/new screen. Display it.
					
					// first column of the screen contains the labels
					echo '<div style="width: 20%; padding: 4px 2em 4px 0px; font-weight: bold; display: inline-block;">';			
					echo $label.'</div> <!-- close of first column -->';
				
					// second column of the screen contains the data entry
					echo '<div style="width: 77%; padding: 4px 0px; display: inline-block;">'.$prefix;
					$sql = explode( " ", $value );
				
					if( true == $editable ) {

						// check to see if the sql for this is VARCHAR()
						$varchar = strpos( $sql[0], 'VARCHAR(' );
						if( ( false !== $varchar ) && ( 0 == $varchar ) ) {
							$end = strpos( $sql[0], ')', 8 );
							$max = intval( substr( $sql[0], 8, ( $end - 8 ) ) );
							$size = ( $max > 60 ) ? 60 : $max;
//							echo "varchar = ".$max.", size = ".$size;
							$default = ( $colData && array_key_exists( 'default', $colData ) ) ? $colData[ 'default' ] : null;
							$default = ( null == $currentData ) ? $default : $currentData[0][ $key ];
//							echo ", default = ".$default;
							echo '<input type="text" name="'.$key.'" maxlength="'.$max.'" size="'.$size.'" value="'.$default.'">';
						}
					
						// check to see if the sql for this is CHAR()
						$char = strpos( $sql[0], 'CHAR(' );
						if( ( false !== $char ) && ( 0 == $char ) ) {
							$end = strpos( $sql[0], ')', 5 );
							$max = intval( substr( $sql[0], 5, ( $end - 5 ) ) );
							$size = ( $max > 60 ) ? 60 : $max;
//							echo "varchar = ".$max.", size = ".$size;
							$default = ( $colData && array_key_exists( 'default', $colData ) ) ? $colData[ 'default' ] : null;
							$default = ( null == $currentData ) ? $default : $currentData[0][ $key ];
//							echo ", default = ".$default;
							echo '<input type="text" name="'.$key.'" maxlength="'.$max.'" size="'.$size.'" value="'.$default.'">';
						}
						
						// check to see if the sql for this is DECIMAL()
						$char = strpos( $sql[0], 'DECIMAL(' );
						if( ( false !== $char ) && ( 0 == $char ) ) {
							$parmstr = substr( $sql[0], 8, -1 );
							$parms = explode( ',', $parmstr );
							if( count( $parms ) < 2 ) {
								$parms[1] = 0;
							}
//							echo "parms = ".$parms[0]." . ".$parms[1];
							$default = ( $colData && array_key_exists( 'default', $colData ) ) ? $colData[ 'default' ] : null;
							$default = ( null == $currentData ) ? $default : $currentData[0][ $key ];
							$format = ".%'.0".$parms[1]."d";
							$step = sprintf( $format, 1 );
							$width = ( $parms[0] + $parms[1] + 2 );	// calculate the approx em width of the element
							$absmax = floatval( str_repeat( "9", $parms[0] ).".".str_repeat( "9", $parms[1] ) );
//							echo "absmax = ".$absmax;
//							echo ", step = ".$step;
//							echo ", default = ".$default;
							echo '<input type="number" name="'.$key.'" max="'.$absmax.'" value="'.$default.'" step="'.$step.'" style="width: '.$width.'em; text-align: right;">';
						}
						
						// check to see if the sql for this is one of the many ints: TINYINT(), SMALLINT(), MEDIUMINT(), INT(), BIGINT()
						$char = strpos( $sql[0], 'INT(' );
						$this->log( 3, "display_db_edit() Looking for INT(, char = ".$char );
						if( ( false !== $char ) && ( $char > 0 ) ) {
							$this->log( 3, "display_db_edit() found INT(, char = ".$char );
							$end = strpos( $sql[0], ')', 4 + $char );
							$max = intval( substr( $sql[0], 4 + $char, ( $end - $char ) ) );
							$size = $max + 1;
							$this->log( 3, "display_db_edit() sql[0] = ".$sql[0].", char = ".$char.", end = ".$end.", size = ".$size );
							$default = ( $colData && array_key_exists( 'default', $colData ) ) ? $colData[ 'default' ] : null;
							$default = ( null == $currentData ) ? $default : $currentData[0][ $key ];
//							echo ", default = ".$default;
							echo '<input type="number" name="'.$key.'" maxlength="'.$max.'" size="'.$size.'" value="'.$default.'" style="text-align: right;">';
						}
						
						// check to see if the sql for this is BOOLEAN
						$char = strpos( $sql[0], 'BOOLEAN' );
						$this->log( 3, "display_db_edit() Looking for BOOLEAN, sql = ".$sql[0].", char = ".$char );
						if( ( false !== $char ) && ( 0 == $char ) ) {
							$default = null;
							$defchar = strpos( $sql[1], 'DEFAULT' );
							$this->log( 3, "display_db_edit() Looking for DEFAULT, sql = ".$sql[1].", defchar = ".$defchar );
							if( false !== $defchar ) {
								$default = ( $sql[2] == 'true' ) ? 1 : 0;
							}
							$this->log( 3, "display_db_edit() DEFAULT  = ".$default );
							$default = ( null == $currentData ) ? $default : $currentData[0][ $key ];
							$checked = ( 1 == $default ) ? " checked " : "";
							echo '<input type="checkbox" name="'.$key.'" value="1" '.$checked.'>';
						}
					
					} else {
					
						// this data is not editable. Just display it if it exists
						if( $currentData !== null ) {
							echo $currentData[0][ $key ];
						}
					}
				
					echo $suffix.'</div> <!-- close of second column -->';
					
					if( true == $sep ) {
						echo "<hr style='height: 0.5px; border-top: 1px solid rgba(0, 0, 0, 0.2); border-bottom: 1px solid rgba(255, 255, 255, 1);' />\n";
					}
				}

			}
			
			// that's all the columns done. Now do buttons
			echo '<input type="hidden" name="table" value="'.$current[ 'name' ].'">';
			echo '<input type="hidden" name="id" value="'.$id.'">';
			$saveLabel = ( 0 == $id ) ? "Save" : "Update";
			$cancelButton = sprintf('<a href="?page=%s" class="button button-secondary">Cancel</a>',$_REQUEST['page'] );
			$saveButton = '<input type="submit" class="button button-primary" value="'.$saveLabel.'">';
			echo '<p>&nbsp;</p>'.$cancelButton." &nbsp; &nbsp; ".$saveButton;
			echo ' </form></div><!-- end of data entry table -->';
			echo '</div>';
		}
		 
		// a small debugging tool to echo the contents of the $_GET object 
		// $flagHTML is a boolean (true/false) that toggles whether or not to include <pre> tags
		public function echo_get( $flagHTML = false ) {
			if( $flagHTML ) {
				echo '<pre>_GET = '.print_r( $_GET, true).'</pre>';
			} else {
				echo '_GET = '.print_r( $_GET, true);		
			}
		}

		// a small debugging tool to echo the contents of the $_POST object 
		// $flagHTML is a boolean (true/false) that toggles whether or not to include <pre> tags
		public function echo_post( $flagHTML = false ) {
			if( $flagHTML ) {
				echo '<pre>_POST = '.print_r( $_POST, true).'</pre>';
			} else {
				echo '_POST = '.print_r( $_POST, true);	
			}
		}

		// a small debugging tool to echo the contents of the $_FILES object 
		// $flagHTML is a boolean (true/false) that toggles whether or not to include <pre> tags
		public function echo_files( $flagHTML = false ) {
			if( $flagHTML ) {
				echo '<pre>_FILES = '.print_r( $_FILES, true).'</pre>';
			} else {
				echo '_FILES = '.print_r( $_FILES, true);	
			}
		}

		
		
		
		
		/**
		 *
		 *	CUSTOM FIELDS
		 *
		 *	If we have Custom Fields added, allow for them.
		 *
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
			$this->log( 2, "add_custom_field_callback() Started. Add ".$field_name."?" );
			if( array_key_exists( $field_name, $_POST ) || ( $fdata['type'] == 'boolean' ) ) {
				$newfuncname = "save_post_meta_".$field_name;
				$this->log( 3, "add_custom_field_callback() add_action outside newfuncname = ".$newfuncname );
				$this->{ $newfuncname } = function( $arga, $argb ) use ($field_name, $fdata) {
					$this->log( 3, "add_custom_field_callback() add_action INSIDE post id = ".$arga );
					$this->log( 3, "add_custom_field_callback() add_action INSIDE field_name = ".$field_name );
					if( array_key_exists( $field_name, $_POST ) ) {
						$this->log( 2, "add_custom_field_callback() update ".$field_name." with form data: ".$_POST[ $field_name ] );
						update_post_meta( $arga, $field_name, $_POST[ $field_name ] );
					} else {
						if( $fdata['type'] == 'boolean' ) {
							$this->log( 2, "add_custom_field_callback() update ".$field_name." with default boolean value of 0." );
							update_post_meta( $arga, $field_name, 0 );
						}
					}
					if( 'parent' == $field_name ) {
						$argb->post_parent = $_POST[ $field_name ];
						$this->log( 2, "add_custom_field_callback() add_action INSIDE field is PARENT, post = ".print_r( $argb, true ) );
					}
				};
				add_action( 'save_post', $this->{ $newfuncname }, 10, 2 );
			} else {
				$this->log( 3, "add_custom_field_callback() ".$field_name." doesn't exist in _POST" );
			} // END of if()
		}
		
		
		/**
		 *	Function to render out the contents of a custom field meta box
		 *	(See http://blog.teamtreehouse.com/create-your-first-wordpress-custom-post-type)
		 *	(See https://developer.wordpress.org/reference/functions/add_meta_box/)
		**/	
		public function render_custom_meta_box( $mypost, $myargs ) {
			$this->log( 3, "render_custom_meta_box() Started. myargs=".print_r( $myargs,true ) );
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
						$checked = ( $custom[ $field_name ][0] == 1 ) ? " checked " : " ";
						echo ' <input type="checkbox" name="'.$field_name.'" '.$checked.' value="1" style="padding: 2px 0px 0px 2px; width: 1.2em; height: 1.2em;"/>';
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
			$this->log( 2, "render_taxonomy_field_meta_box() Started. tag = ".print_r( $tag, true ) );
//			$this->log( 3, "render_taxonomy_field_meta_box() taxonomy = ".$tag->taxonomy);
			$term_data = $this->custom_taxonomies[ $tag->taxonomy ];
//			$this->log( 3, "render_taxonomy_field_meta_box() data = ".print_r( $term_data, true ) );
			echo "<div style='width: 100%; background-color: #f2f2f2; border: 1px solid #777;'>";
			echo "<h2>Custom taxonomy fields</h2>";
			foreach( $term_data['custom_fields'] as $field ) {
				$this->log( 2, "render_taxonomy_field_meta_box() looping field = ".print_r( $field, true ) );
				echo "<p><label>".$field[ 'name' ]."</label><br />";
			}
			echo "</div>";
		}

		
		
		/**
		 *
		 *	CUSTOM POST TYPES
		 *
		 *	If we have Custom Post Types added, create them
		 *
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
			if( ( true == $this->ajax_users_only ) && ( !is_user_logged_in() ) ) {
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
					$this->log( 3, "do_ajax() ajax_response = ".print_r( $this->ajax_response, true ) );
				} else {
					$this->ajax_response['error'] = "[ERROR. Unknown command '".$this->ajax_response['command']."']";
				}
			} else {
				$this->ajax_response['error'] = "No valid command provided.";
			}
			
			// All processing is complete. Encode the response and send it.
			$this->ajax_response_text = json_encode($this->ajax_response);
			$this->log( 2, "do_ajax() json=".$this->ajax_response_text );
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
				$this->log( 2,"add_admin_menus() There is at least one menu to add to the Admin screen." );
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
			$this->log( 2,"do_admin_menus() Started. type=".$type );
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
						$this->log( 2,"display_admin_screen() Admin menu information not found for ".$currentScreen->id );
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
//						echo "Looking for submenus ...index = ".$index."<br />\n";
						if( array_key_exists( 'submenus', $this->admin_menus[ 'menu' ] ) ) {
//							echo "Found submenus ... Looking for index ...<br />\n";
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
		 *	get Critical Content
		 *
		 *	An attempt to provide a system that will allow some content to be provided from another url.
		 *	The idea is to be able to remotely switch on or off the plugin if the client doesn't pay, or is similarly a twat.
		 *	Returns an JSON-decoded object/array as required.
		**/
		
		function get_cc( $opts = array() ) {
			$this->log( 3,"get_cc() Started." );
			$this->curl_error = null;
			$this->curl_errorno = 0;
			$curl = curl_init();
			$opts[ 'data' ][ 'caller' ] = $this->slug;
			$opts[ 'data' ][ 'object' ] = ( array_key_exists( 'object', $opts ) ) ? $opts[ 'object' ] : false; // true object, false code
			curl_setopt_array( $curl, array(
				CURLOPT_URL => ( array_key_exists( 'url', $opts ) ) ? $opts[ 'url' ] : "https://october.com.au/soft/october_cc.php",
				CURLOPT_RETURNTRANSFER => ( array_key_exists( 'returntxr', $opts ) ) ? $opts[ 'returntxr' ] : true,
				CURLOPT_TIMEOUT => ( array_key_exists( 'timeout', $opts ) ) ? $opts[ 'timeout' ] : 20,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
				CURLOPT_POSTFIELDS => http_build_query( ( array_key_exists( 'data', $opts ) ) ? $opts[ 'data' ] : array() )
			) );

			$response = curl_exec($curl);
			$this->curl_errorno = curl_errno( $curl );
			$this->curl_error = ( curl_errno( $curl ) > 0 ) ? curl_errno( $curl ).": ".curl_error( $curl ) : null;
			curl_close($curl);

			if( $this->curl_errorno > 0 ) {
				$this->log( 1,"get_cc() curl error = ".$this->curl_error );
				return null;
			}

			if( $opts[ 'data' ][ 'object' ] ) {
				return json_decode( $response );
			}
			
			return $response;
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