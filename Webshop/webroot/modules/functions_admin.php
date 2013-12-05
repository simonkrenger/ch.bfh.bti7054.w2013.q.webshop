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
	
	$id_attribute_name = get_id($attributes);
		
	// Print header
	echo "<table><tr><th></th>";
	foreach ( $attributes as $attribute_name ) {
		echo "<th>$attribute_name</th>";
	}
	echo "</tr>";
		
	// Print content
	foreach($all_items as $item) {
		echo "<tr>";
		echo '<td><a href="' . get_href("admin", array("action" => "delete", "type" => $typename, "id" => $item->$id_attribute_name)) . '">[-]</a></td>';
		foreach ( $attributes as $attribute_name ) {
			echo "<td>" . $item->$attribute_name . "</td>";
		}
		echo "</tr>";
	}
		
	echo "</table>";
	echo '<a href="' . get_href("admin", array("action" => "add", "type" => $typename)) . '">[+] Add new ' . $typename . '</a>';
	echo "<hr/>";
}

function admin_show_form($type=null, $id=null) {
	if(isset($type)) {
		
		global $shopdb;
		
		// Dummy query to only get table metadata
		$dummy = $shopdb->get_results("SELECT * FROM $shopdb->escape($type) WHERE 0=1");
		$attributes = $shopdb->get_col_info("name");
		
		$id_attribute_name = get_id($attributes);
		
		if($id != null) {
			// Edit mode, get the current values
			$edit_values = $shopdb->get_row("SELECT * FROM $shopdb->escape($type) WHERE $id_attribute_name = $shopdb->escape($id)");
		}

		if(isset($edit_values)) {
			echo '<form action="' . get_href("admin", array("action" => "doedit", "type" => $type)) . '" method="post">';
		} else {
			echo '<form action="' . get_href("admin", array("action" => "doadd", "type" => $type)) . '" method="post">';
		}
		
		// Generate <input> for each attribute
		foreach ( $attributes as $attribute_name ) {
			if($attribute_name == $id_attribute_name) {
				// Do not display ID
				echo '<input type="hidden" ';
			} else {
				echo '<br/>' . $attribute_name . ': <input type="text" ';
			}
			echo 'name="' . $attribute_name . '"';
			echo  'value="' . $edit_values->$attribute_name . '" />';
		}
		
		echo '<input type="submit" value="Submit">';
		echo "</form>";
		
	} else {
		echo "Error: No type provided";
	}
}

function admin_add($type) {
	if(isset($type)) {
		global $shopdb;
		
		// Dummy query to only get table metadata
		$dummy = $shopdb->get_results("SELECT * FROM $shopdb->escape($type) WHERE 0=1");
		$attributes = $shopdb->get_col_info("name");
		
		$id_attribute_name = get_id($attributes);
		
		// Assemble query
		$query = 'INSERT INTO ' . $shopdb->escape($type) . ' ';
		$query .= '(';
		
		$comma=false;
		foreach ( $attributes as $attribute_name ) {
			if(! ($attribute_name == $id_attribute_name)) {
				if($comma) {
					$query .= ', ';
				} else {
					$comma = true;
				}
				$query .= $shopdb->escape($attribute_name);
			}
		}
		
		$query .= ') VALUES (';
		
		$comma=false;
		foreach ( $attributes as $attribute_name ) {
			if(! ($attribute_name == $id_attribute_name)) {
				if($comma) {
					$query .= ', ';
				} else {
					$comma = true;
				}
				$query .= "'" . $shopdb->escape($_POST[$attribute_name]) . "'";
			}
		}
		
		$query .= ')';
		
		$shopdb->query($query);
		
		$shopdb->vardump();
	} else {
		echo "Error: No type provided";
	}
}

function get_id($attributes) {
	// Try to evaluate which is the ID of the type
	foreach ( $attributes as $attribute_name ) {
		if(preg_match("/.*\_id$/", $attribute_name) == 1) {
			$id_attribute_name = $shopdb->escape($attribute_name);
			// Break on first match
			break;
		}
	}
	return $id_attribute_name;
}

?>