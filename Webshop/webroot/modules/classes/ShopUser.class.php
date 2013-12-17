<?php
class ShopUser {
	
	public $address;
	public $username;
	
	
	// Variables are bound dynamically
	
	public function ShopUser($user_id) {
		global $shopdb;
		
		$clean_id = $shopdb->escape($user_id);
		$query = sprintf("SELECT user_id, username, email, first_name, last_name, role_id, address_id FROM user WHERE user_id=%s LIMIT 1", $clean_id);
		$user_attrs = $shopdb->get_row($query);
		
		if($user_attrs != NULL) {
			// Dynamically bind all variables
			foreach(get_object_vars($user_attrs) as $attr_name => $attr_value) {
				$this->$attr_name = $attr_value;
			}
		}
		
		// Get address
		$this->address = new ShopUserAddress($this->address_id);
	}
}

class ShopUserAddress {
	public function ShopUserAddress($user_id) {
		global $shopdb;
		
		$clean_id = $shopdb->escape($user_id);
		$query = sprintf("SELECT a.address_id, a.street, a.zipcode, a.city, a.country, p.name, g.name FROM address a JOIN planet p ON a.planet_id = p.planet_id JOIN galaxy g ON a.galaxy_id = g.galaxy_id WHERE address_id=%s LIMIT 1", $clean_id);
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