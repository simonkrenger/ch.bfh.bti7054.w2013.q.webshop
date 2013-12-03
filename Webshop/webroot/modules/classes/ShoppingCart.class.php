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
		//ToDo db abfrage für product details
		
		echo "<table border=\"1\">";
		echo "<tr><th>Article</th><th>Items</th></tr>";
		foreach ( $this->items as $art => $num ) ;
			
		echo "<tr><td>$art</td><td>$num</td></tr>";
		echo "</table>";
		
		$prod_info = $this->getProductInformation($art);
		echo $prod_info->name;
		
		
		//echo "<div class=\"cartField\"> <label for =\"name\">ProductName</label><input type=\"" . $entry [2] . "\" name=\"" . $entry[0] . "\" size=\"" . $entry[3] . "\" maxlength=\"" . $entry[4] . "\" id=\"" . $entry[0] . "\" placeholder =\"" . $entry[0] . "\"></div>";
	
	
	}
	
	private function getProductInformation($id){
		global $shopdb;
		$product_id = $shopdb->escape($id);
		$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $id );
		return $shopdb->get_row( $query );
	}
	
	public function displaySmall(){
		//TODO Displya funktion for sidebar
	}
	
	
	public function clear() {
		unset ( $this->items );
	}
}
?>