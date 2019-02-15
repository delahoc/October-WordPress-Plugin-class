<?php 

/**	
 *	This class helps to speed up the development of WP_List_Tables
 *	by providing all the base functionality and settings required.
 *	This class is assumed to be used / populated by the october-plugin class.
**/

/**	
 *	Copyright 2019 October Productions. All Rights Reserved.
 *	No unauthorised use, modification or duplication.
 *	Contact us for details: www.october.com.au
**/

/**
 *	v0.2 Updates:
 *	14/2/19 Added support for hidden columns
**/

// These few lines are only required because the database functionality is used.

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class octo_list_table extends WP_List_Table {
		
	public	$data = null;				// Fill this with all the data arrays required to be displayed
	public	$columns = array();			// Fill this array with the key => value pairs required for columns
	public	$hidden = array();			// Fill this array with the fields of columns that will be hidden
	public	$sortable = array();		// Fill this array with the items required for sortable columns
	public	$bulk_actions = array();	// Fill this array with the key => value pairs required for bulk actions
	public	$actions = array();			// Fill this array with the arrays required for column-specific actions
	public	$filters = array();			// Fill this array with the extra-nav filter arrays
	public	$custom_displays = array();	// Fill this array with the col => type pairs for custom column displays

	function get_columns() {}			// We override the method as required, but don't use it
		
	function get_sortable_columns() {}	// We override the method as required, but don't use it
		
	function get_bulk_actions() {
		return $this->bulk_actions;
	}
		
	function prepare_items() {
		$this->_column_headers = array( $this->columns, $this->hidden, $this->sortable );
		$this->items = $this->data;
	}
		
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="cat[]" value="%s" />', $item['id']
		);    
	}
		
	function column_name ( $item ) {
		$actions = array(
			'edit'      => sprintf('<a href="?page=%s&action=%s&cat=%s">Edit</a>',$_REQUEST['page'],'edit',$item['id']),
			'delete'    => sprintf('<a href="?page=%s&action=%s&cat=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
		);
		return sprintf('%1$s %2$s', $item[ 'name' ], $this->row_actions($actions) );
	}
		
	function column_default( $item, $column_name ) {
//		october_plugin::slog( "WPLT class::column_default() started. actions = ".print_r( $this->actions, true ) );
		$column_actions = null;
		// check for any actions for this column
		if( array_key_exists( $column_name, $this->actions ) ) {
			foreach( $this->actions[ $column_name ] as $action_data ) { // there may be more than one action per column
//				october_plugin::slog( "WPLT class::column_default() looping. action_data = ".print_r( $action_data, true ) );
				$column_actions[ $action_data[ 'slug' ] ] =
					sprintf('<a href="?page=%s&action=%s&cat=%s&col=%s&val=%s">%s</a>',
						$_REQUEST[ 'page' ], $action_data[ 'slug' ], $item['id'],  
							$column_name, $item[ $column_name ], $action_data[ 'label' ] );
			}
		}
		if( array_key_exists( $column_name, $this->columns ) ) {
			$value = $item[ $column_name ];
			if( array_key_exists( $column_name, $this->custom_displays ) ) {
//				october_plugin::slog( "WPLT class::column_default() found a column requiring a custom display. col = ".$column_name.", display = ".$this->custom_displays[ $column_name ] );
				if( 'true_false' == $this->custom_displays[ $column_name ] ) {
					$value = ( 1 == $item[ $column_name ] ) ?
						"<span style='color: green; font-weight: 500;'>True</span>" :
						"<span style='color: red; font-weight: 500;'>False</span>";
				}	
			}
			
			return sprintf('%1$s %2$s', $value, $this->row_actions( $column_actions ) );
		} else {
			return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes			
		}
	}

	function extra_tablenav( $which ) {
//		october_plugin::slog( "WPLT class::extra_tablenav() started. which = ".$which );
		if( 'top' == $which && $this->filters !== null ) {
//			october_plugin::slog( "WPLT class::extra_tablenav() Add top filters." );
			?>
		        <div class="alignleft actions bulkactions">
	        <?php
			foreach( $this->filters as $col => $data ) {
//				october_plugin::slog( "WPLT class::extra_tablenav() Add top filter for ".$col );
				?>
					<select name="filter_<?php echo $col; ?>" id="filter_<?php echo $col; ?>">
					<?php
						$selected = "";
						$passedval = "*NO VALUE PASSED*";
						if( array_key_exists( 'filter_'.$col, $_GET ) || array_key_exists( 'filter_'.$col, $_POST ) ) {
							$passedval = array_key_exists( 'filter_'.$col, $_GET ) ? $_GET[ 'filter_'.$col ] : $_POST[ 'filter_'.$col ];
//							october_plugin::slog( "WPLT class::extra_tablenav() A filter has been passed for ".$col." = ".$passedval );
						} else {
							$passedval = "*NO VALUE PASSED*";
//							october_plugin::slog( "WPLT class::extra_tablenav() NO filter passed for ".$col );							
						}
						foreach( $data as $key => $val ) {
							$selected = ( (string)$val == (string)$passedval ) ? "selected" : "";
							echo "<option value='".$val."' ".$selected.">".$key."</option>\n";
						}
					?>
					</select>
				<?php
			}
			?>
				<input type="submit" id="doaction" class="button action" value="Filter">
				</div>
	        <?php
		}
	}
	
	
} // END of octo_list_table class

?>