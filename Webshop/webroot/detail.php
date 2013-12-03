<?php

if (isset ( $_GET ['product_id'] )) {
	$product_id = $shopdb->escape($_GET ['product_id']);
	$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
	$product_info = $shopdb->get_row( $query );
	
	$product_attrs = $shopdb->get_row( "SELECT 1 FROM dual");
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

			<div class="box" id="planetAttributes">[atributes]</div>

			<div class="box" id="planetButtons">
			
			

			</div>
			
			<a href="<?php
				$suffix = array("product_id" => $product_id);
				echo get_href("shoppinglist", $suffix); ?>">Add to shopping Cart</a>
			
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