<?php

function admin_get_types() {
	return array("user", "planet", "galaxy");
}

function admin_list($type=null) {
	if($type != null) {
		admin_list_print_type($type);
	} else {
		foreach(admin_get_types() as $t) {
			admin_list_print_type($t);
		}
	}
}

function admin_list_print_type($typename) {
	global $shopdb;
	
	// Query to get all attributes and all rows
	$all_items = $shopdb->get_results("SELECT * FROM $shopdb->escape($typename)");
	$attributes = $shopdb->get_col_info("name");
		
	// Print header
	echo "<table><tr>";
	foreach ( $attributes as $attribute_name ) {
		echo "<th>$attribute_name</th>";
	}
	echo "</tr>";
		
	// Print content
	foreach($all_items as $item) {
		echo "<tr>";
		foreach ( $attributes as $attribute_name ) {
			echo "<td>" . $item->$attribute_name . "</td>";
		}
		echo "</tr>";
	}
		
	echo "</table>";
	echo '<a href="' . get_href("admin", array("action" => "add", "type" => $typename)) . '">[+] Add new ' . $typename . '</a>';
	echo "<br/>";
}

function admin_show_form($type=null, $id=null) {
	if(isset($type)) {
		
		global $shopdb;
		
		// Dummy query to only get table metadata
		$dummy = $shopdb->get_results("SELECT * FROM $shopdb->escape($type) WHERE 0=1");
		$attributes = $shopdb->get_col_info("name");
		
		if($id != null) {
			
			// Edit mode
			
			// Try to evaluate which is the ID of the type
			foreach ( $attributes as $attribute_name ) {
				if(preg_match("/.*\_id$/", $attribute_name) == 1) {
					$id_attribute = $shopdb->escape($attribute_name);
					// Break on first match
					break;
				}
			}
			
			$edit_values = $shopdb->get_row("SELECT * FROM $shopdb->escape($type) WHERE $id_attribute = $shopdb->escape($id)");
		}

		if(isset($edit_values)) {
			echo '<form action="' . get_href("admin", array("action" => "doedit")) . '" method="post">';
		} else {
			echo '<form action="' . get_href("admin", array("action" => "doadd")) . '" method="post">';
		}
		
		foreach ( $attributes as $attribute_name ) {
			// Display <input>
			echo $attribute_name . ': <input type="text" name="';
			echo $attribute_name . '" value="' . $edit_values->$attribute_name;
			echo '" /><br/>';
		}
		
		echo "</form>";
		
	} else {
		echo "Error: No type provided";
	}
}

function admin_add($post_array) {
	// When adding, remove ID
	
	// Try to evaluate which is the ID of the type
	foreach ( $attributes as $attribute_name ) {
		if(preg_match("/.*\_id$/", $attribute_name) == 1) {
			$id_attribute = $shopdb->escape($attribute_name);
			// Break on first match
			break;
		}
	}
}

?>