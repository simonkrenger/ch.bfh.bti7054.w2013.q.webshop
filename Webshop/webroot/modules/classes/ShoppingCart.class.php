<?php
class ShoppingCart {
	
	// Array containing (<ShopProduct>))
	private $items = array ();
	
	public function addProduct(ShopProduct $s) {
		array_push($this->items, $s);
	}
	
	public function removeProduct($prod_id) {
		foreach ($this->items as $itemkey => $item) {
			if($item->product_id == $prod_id) {
				unset($this->items[$itemkey]);
				return;
			}
		}
	}
	
	public function displayFull() {
		require_lang();
		if (!empty($this->items)) {
			
			echo '<table class="cartFull">';
			echo '<tr>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_NAME") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_DESCRIPTION") . '</th>';
			echo '<th class="cartField">' . get_translation("SHOPPINGCART_PRICE") . '</th>';
			echo '<th class="cartField"> Actions </th>';
			echo '</tr>';
			
			$total_price = 0;
			
			foreach ( $this->items as $prod ) {
				$prod_info = $prod->getProductInfo();
				echo "<tr>";
				echo "<td class=\"cartField\">" . $prod_info->name . "</td>";
				echo "<td class=\"cartField\"><ul>";
				foreach ($prod->attributes as $attr_id => $attr_value) {
					echo "<li>" . $prod->getAttributeNameForId($attr_id) . ": " . urldecode($attr_value) . "</li>";
				}
				echo "</ul></td>";
				echo "<td class=\"cartField\">" . $prod_info->price . "</td>";
				$total_price += $prod_info->price;
				echo "<td class=\"cartField\"><a href=\"" . get_href("shoppingcart", array("action" => "delete", "product_id" => $prod_info->product_id)) . "\">Remove</a></td>";
				echo "</tr>";
			}
			
			echo "<tr><td class=\"cartField\">Total</td><td class=\"cartField\"></td><td class=\"cartField\">$total_price</td><td class=\"cartField\"></td></tr>";
			
			echo '</table>';
		} else {
			echo get_translation("SHOPPINGCART_EMPTY");
		}
	}
	
	public function displaySmall(){
		require_lang();
		
		if (!empty($this->items)){
			$overview = $this->getQuantities();
			
			// Show aggregated values
			echo "<ul>";
			foreach ($overview as $prod_id => $no_of_items) {
				$p = new ShopProduct($prod_id);
				$prod_info = $p->getProductInfo();
				echo "<li>" . $no_of_items . "x " . $prod_info->name . "</li>";
			}
			echo "</ul>";
			
		} else {
			echo get_translation("SHOPPINGCART_EMPTY");
		}
	}
	
	public function getQuantities() {
		$overview = array();
			
		// Aggregate
		foreach ($this->items as $item) {
			if($overview[$item->product_id] == NULL) {
				$overview[$item->product_id] = 1;
			} else {
				$overview[$item->product_id]++;
			}
		}
		
		return $overview;
	}
	
	public function clear() {
		unset ( $this->items );
	}
	
	public function is_empty() {
		return empty($this->items);
	}
	
	public function getAllItems() {
		return $this->items;
	}
}
?>