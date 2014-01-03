<?php

function admin_get_types() {
	return array("user", "product_category", "product", "planet", "galaxy", "`order`");
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
	echo "<table><tr>";
	foreach ( $attributes as $attribute_name ) {
		echo "<th>$attribute_name</th>";
	}
	echo "<th>Action</th>";
	echo "</tr>";
		
	// Print content
	foreach($all_items as $item) {
		echo "<tr>";
		foreach ( $attributes as $attribute_name ) {
			echo "<td>" . $item->$attribute_name . "</td>";
		}
		echo '<td>';
		echo '<a href="' . get_href("admin", array("action" => "delete", "type" => $typename, "id" => $item->$id_attribute_name)) . '">[delete]</a>';
		echo '<a href="' . get_href("admin", array("action" => "edit", "type" => $typename, "id" => $item->$id_attribute_name)) . '">[edit]</a>';
		echo '</td>';
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
			echo '<form action="' . get_href("admin", array("action" => "doedit", "type" => $type, "id" => $id)) . '" method="post">';
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

function admin_show_delete_form($type=null, $id=null) {
	if(isset($type) && isset($id)) {
		echo '<form action="' . get_href("admin", array("action" => "dodelete", "type" => $type)) . '" method="post">';
		
		echo "Are you sure you want to delete the following item:<br/><br/>";
		
		echo "Type: $type<br/>";
		echo "ID: $id<br/>";
		
		echo '<input type="hidden" name="delete_id" value="' . $id . '" />';
		
		echo '<input type="submit" value="Delete">';
		echo '</form>';
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
		
		foreach ( $attributes as $attribute_name ) {
			if(! ($attribute_name == $id_attribute_name)) {
				$query .= "," . $shopdb->escape($attribute_name);
			}
		}
		
		$query .= ') VALUES (';
		
		foreach ( $attributes as $attribute_name ) {
			if(! ($attribute_name == $id_attribute_name)) {
				$query .= ",'" . $shopdb->escape($_POST[$attribute_name]) . "'";
			}
		}
		
		$query .= ')';
		
		// Fix syntax
		$query = str_replace("(,", "(", $query);
		
		$shopdb->query($query);
		// TODO: Error handling
		
		echo $type . ' inserted.';
		
	} else {
		echo "Error: No type provided";
	}
}

function admin_update($type=null, $id=null) {
	if(isset($type) && isset($id)) {
		global $shopdb;
		
		// Dummy query to only get table metadata
		$dummy = $shopdb->get_results("SELECT * FROM $shopdb->escape($type) WHERE 0=1");
		$attributes = $shopdb->get_col_info("name");
		
		$id_attribute_name = get_id($attributes);
		
		// Assemble query
		$query = 'UPDATE ' . $shopdb->escape($type) . ' SET ';
		
		foreach ( $attributes as $attribute_name ) {
			if(! ($attribute_name == $id_attribute_name)) {
				$query .= $attribute_name . "='" . $shopdb->escape($_POST[$attribute_name]) . "',";
			}
		}
		
		$query .= "WHERE $id_attribute_name=$shopdb->escape($id)";
		
		// Fix syntax (remove last comma)
		$query = str_replace(",WHERE", " WHERE", $query);
		
		$shopdb->query($query);
		// TODO: Error handling
		
		echo 'Updated ' . $type . ' with ID ' . $id . '.';
		
	} else {
		echo "Error: No type or id provided";
	}
}

function admin_delete($type) {
	if(isset($type) && isset($_POST["delete_id"])) {
		global $shopdb;

		// Dummy query to only get table metadata
		$dummy = $shopdb->get_results("SELECT * FROM $shopdb->escape($type) WHERE 0=1");
		$attributes = $shopdb->get_col_info("name");

		$id_attribute_name = get_id($attributes);
		
		$query = "DELETE FROM ";
		$query .= $shopdb->escape($type);
		$query .= " WHERE $id_attribute_name = ";
		$query .= $shopdb->escape($_POST['delete_id']);
		
		$shopdb->query($query);
		// TODO: Error handling
		
		echo 'Deleted ' . $type . ' with ID ' . $_POST["delete_id"];
		
	} else {
		echo "Error: No type or DELETE_ID set";
	}
}


function get_id($attributes) {
	global $shopdb;
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