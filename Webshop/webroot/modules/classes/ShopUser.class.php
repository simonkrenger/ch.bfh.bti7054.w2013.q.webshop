<?php
class ShopUser {
	
	// Variables are bound dynamically
	
	public function ShopUser($user_id) {
		global $shopdb;
		
		$clean_id = $shopdb->escape($user_id);
		$query = sprintf("SELECT user_id, username, email, first_name, last_name, role_id FROM user WHERE user_id=%s LIMIT 1", $clean_id);
		$user_attrs = $shopdb->get_row($query);
		
		if($user_attrs != NULL) {
			// Dynamically bind all variables
			foreach(get_object_vars($user_attrs) as $attr_name => $attr_value) {
				$this->$attr_name = $attr_value;
			}
		}
	}
}
?>