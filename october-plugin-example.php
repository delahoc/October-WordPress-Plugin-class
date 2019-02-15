<?php

/* 
 *	Plugin Name: Example plugin
 *	Plugin URI: http://www.october.com.au
 *	Description: An example plugin to demonstrate how to use the october plugin class
 *	Version: 0.1
 *	Author: Craig Delahoy 
 *	Author URI: http://www.october.com.au
 *	License: GPLv2 or later. 
 *	Copyright: 2018 October Productions
 */ 

// Copyright 2018 October Productions - All Rights Reserved
// No unauthorised duplication or modification permitted. NONE!

include_once( "october-plugin-class.php" );

date_default_timezone_set( 'Australia/Sydney' );

if( !class_exists( 'october_sample' ) ) {
    class october_sample extends october_plugin {
    	public $version = 001;			// also update in text above
		public $copyright = 'Copyright 2018, October Productions.';
		
	} // END class october_sample
} // END if

if( class_exists( 'october_sample' ) ) { 
	// instantiate the plugin class 
	$osample = new ourswop_tools( "october_sample" );
	$osample->log( 2, "New object created." );
}

