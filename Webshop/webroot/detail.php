<?php

if (isset ( $_GET ['product_id'] )) {
	$product_id = $shopdb->escape($_GET ['product_id']);
	
	$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
	$product_info = $shopdb->get_row( $query );
	
	$query = sprintf("SELECT pa.attribute_id, pa.name, pa.description, pa.value_range FROM product_attribute pa JOIN product_type pt ON pa.product_type_id = pt.type_id JOIN product p ON p.product_type=pt.type_id WHERE p.product_id=%s", $product_id);
	$product_attrs = $shopdb->get_results($query);	
}

?>
<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php 
		if (isset ( $product_info ) && isset( $product_attrs )) {
		?>
			<h2><?php  echo $product_info->name; ?></h2>
		
			<div class="box" id="planetPicture">[picture of Planet]</div>

			<div class="box" id="planetDescription"><?php echo $product_info->description; ?></div>

			<div class="box" id="planetAttributes">
			<ul>
			<?php 
			
			foreach($product_attrs as $attribute) {
				echo "<li><strong>$attribute->name: $attribute->value_range</strong><br/>$attribute->description</li>";
			}
			
			?>
			</ul></div>

			<div class="box" id="planetButtons" >			
			
			<a href="<?php
				$suffix = array("product_id" => $product_id, "action" => "add");
				echo get_href("shoppingCart", $suffix); ?>">Add to shopping Cart</a><br>
			
			
				<a href="<?php
				$suffix = array("product_id" => $product_id);
				echo get_href("order", $suffix); ?>">Buy Now!</a>

			</div>
			
		<?php 
		} else {
		?>
		
		<div class="box" id="planetPicture">Error: No product_id provided.</div>
		
		<?php 
		}
		?>
		</div>

	</div>
			<?php include('sidebar.php'); ?>
</div>
