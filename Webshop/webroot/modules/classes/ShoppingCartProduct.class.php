<?php

class ShoppingCartProduct {
	public $product_id;
	
	public $attributes = array();
	
	
	public function ShoppingCartProduct($p_id) {
		global $shopdb;
		
		$product_id = $shopdb->escape($p_id);
		$query = sprintf( "SELECT pa.attribute_id, pav.value FROM product p LEFT JOIN product_attribute_value pav ON pav.product_id = p.product_id RIGHT JOIN product_attribute pa ON pav.product_attribute_id = pa.attribute_id WHERE pav.product_id=%s", $product_id );
		$product_attrs = $shopdb->get_results ( $query );
		
		foreach($product_attrs as $attr) {
			$attributes = array_merge($attributes, array($attr->attribute_id, $attr->value));
		}
	}
	
	public function addCustomAttribute($attribute_id, $attribute_value) {
		$attributes = array_merge($attributes, array($attribute_id, $attribute_value));
	}
	
	public function getAttributeNameForId($attribute_id) {
		global $shopdb;
		
		$clean_id = $shopdb->escape($attribute_id);
		$query = sprintf("SELECT name FROM product_attribute WHERE attribute_id=%1", $clean_id);
		return $shopdb->get_var($query);
	}
	
	public function getProductInfo() {
		global $shopdb;
		
		$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
		return $shopdb->get_row ($query);
	}
}

?>