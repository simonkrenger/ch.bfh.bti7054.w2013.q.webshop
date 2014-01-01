<?php
class ShoppingCart {
	
	private $items = array ();
	
	public function addItem($art, $num) {
		if (! isset ( $this->items [$art] )) {
			$this->items [$art] = 0;
		}
		$this->items [$art] += $num;
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
			
			foreach ( $this->items as $art => $num ) {
				$prod_info = $this->getProductInformation($art);
				echo "<tr>";
				echo "<td class=\"cartField\">" . $prod_info->name . "</td>";
				echo "<td class=\"cartField\">" . $prod_info->description . "</td>";
				echo "<td class=\"cartField\">" . $prod_info->price . "</td>";
				echo "<td class=\"cartField\">" . $num . "</td>";
				echo "<td class=\"cartField\">" . $num * $prod_info->price . "</td>";
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
			foreach ( $this->items as $art => $num ) {
				$prod_info = $this->getProductInformation($art);
				echo "<tr><li>";
				echo "<td class=\"cartField\">" . $num . "x </td>";
				echo "<td class=\"cartField\">" .  $prod_info->name . "</td>";
				echo "</li></tr>";
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