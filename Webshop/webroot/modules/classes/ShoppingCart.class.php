<?php
class ShoppingCart {
	
	// Array containing (product_id=<prod_id>, product=<ShoppingCartProduct>, quantity=<quantity>))
	private $items = array ();
	
	public function addItem($art, $num) {
		if (! isset ( $this->items [$art] )) {
			$this->items [$art] = 0;
		}
		$this->items [$art] += $num;
	}
	
	public function addProduct(ShoppingCartProduct $s) {
		if(! isset( $this->items[$s->product_id])) {
			array_push($this->items, 
			array(
				"product_id" => $s->product_id,
				"product" => $s,
				"quantity" => 1
			));
		} else {
			// TODO
		}
	}
	
	public function removeProduct(ShoppingCartProduct $s) {
		// TODO
	}
	
	public function removeItem($art, $num) {
		if (isset ( $this->items [$art] ) && $this->items [$art] >= $num) {
			$this->items [$art] -= $num;
			if ($this->items [$art] == 0)
				unset ( $this->items [$art] );
			return true;
		} else
			return false;
	}
	
	public function displayFull() {
		require_lang();
		
		if (!empty($this->items)) {
			
			echo '<table class="cartFull">';
			echo '<tr>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_NAME") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_DESCRIPTION") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_PRICE") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_QUANTITY") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_TOTAL") . '</th>';
			echo '</tr>';
			
			foreach ( $this->items as $product_array ) {
				// This is a "ShoppingCartProduct"
				$prod = $product_array["product"];
				
				$prod_info = $prod->getProductInfo();
				echo "<tr>";
				echo "<td class=\"cartField\">" . $prod_info->name . "</td>";
				echo "<td class=\"cartField\"><ul>";
				foreach ($prod->attributes as $attr_id => $attr_value) {
					echo "<li>" . $prod->getAttributeNameForId($attr_id) . ": " . urldecode($attr_value) . "</li>";
				}
				echo "</ul></td>";
				echo "<td class=\"cartField\">" . $prod_info->price . "</td>";
				echo "<td class=\"cartField\">" . $product_array["quantity"] . "</td>";
				echo "<td class=\"cartField\">" . $product_array["quantity"]*$prod_info->price . "</td>";
				echo "</tr>";
			}
			
			echo '</table>';
		} else {
			echo get_translation("SHOPPINGCART_EMPTY");
		}
	}
	

	
	public function displaySmall(){
		require_lang();
		
		if (!empty($this->items)){
			echo "<ul>";
		foreach ( $this->items as $product_array ) {
				// This is a "ShoppingCartProduct"
				$prod = $product_array["product"];
				$prod_info = $prod->getProductInfo();
				$quant = $product_array["quantity"];
				echo "<li>" . $quant ."x " . $prod_info->name . "</li>";
			}
			echo "</ul>";
		} else {
			echo get_translation("SHOPPINGCART_EMPTY");
		}
	}
	
	private function getProductInformation($id){
		global $shopdb;
		$product_id = $shopdb->escape($id);
		$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id  );
		return $shopdb->get_row( $query );
	}
	
	
	public function clear() {
		unset ( $this->items );
	}
	
	public function is_empty() {
		return empty($this->items);
	}
}
?>