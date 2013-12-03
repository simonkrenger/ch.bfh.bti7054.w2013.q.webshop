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
	
	// Dummy query to get all rows
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
}

?>