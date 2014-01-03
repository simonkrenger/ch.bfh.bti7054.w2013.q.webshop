<?php
class ShopProduct {
	public $product_id;
	
	// Array to hold the attributes ($attibute_id => $attribute_value)
	public $attributes = array ();
	public function ShopProduct($p_id) {
		global $shopdb;
		
		$this->product_id = $shopdb->escape ( $p_id );
		$query = sprintf ( "SELECT pa.attribute_id, pav.value FROM product p LEFT JOIN product_attribute_value pav ON pav.product_id = p.product_id RIGHT JOIN product_attribute pa ON pav.product_attribute_id = pa.attribute_id WHERE pav.product_id=%s", $this->product_id );
		$product_attrs = $shopdb->get_results ( $query );
		
		// Get all attributes and set them
		// Non-custom attributes have their value correctly assigned
		// Custom attributes have "NULL" as their value
		foreach ( $product_attrs as $attr ) {
			$this->attributes[$attr->attribute_id] = $attr->value;
		}
	}
	
	/**
	 * Gets all attributes from the product where the attribute value is NULL (custom values)
	 * 
	 * @return A list of attribute ids that are NULL
	 */
	public function getNullAttributes() {
		$ret = array ();
		foreach ( $this->attributes as $key => $value ) {
			if ($value == NULL) {
				// NULL means that this is a custom attribute
				array_push ( $ret, $key );
			}
		}
		return $ret;
	}
	
	public function addCustomAttribute($attribute_id, $attribute_value) {
		$this->attributes[$attribute_id] = $attribute_value;
	}
	public function getAttributeNameForId($attribute_id) {
		global $shopdb;
		
		$clean_id = $shopdb->escape ( $attribute_id );
		$query = sprintf ( "SELECT name FROM product_attribute WHERE attribute_id=%s", $clean_id );
		return $shopdb->get_var ( $query );
	}
	public function getProductInfo() {
		global $shopdb;
		
		$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $this->product_id );
		return $shopdb->get_row ( $query );
	}
}

?>