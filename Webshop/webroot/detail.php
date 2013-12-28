<?php

if (isset ( $_GET ['product_id'] )) {
	$product_id = $shopdb->escape($_GET ['product_id']);
	
	$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
	$product_info = $shopdb->get_row( $query );
	
	$query = sprintf("SELECT attribute_id, pa.name, attribute_value_id, pa.description, pav.value, value_range FROM product p LEFT JOIN product_attribute_value pav ON pav.product_id = p.product_id RIGHT JOIN product_attribute pa ON pav.product_attribute_id = pa.attribute_id WHERE pav.product_id=%s", $product_id);
	$product_attrs = $shopdb->get_results($query);	
}

?>
<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php 
		if (isset ( $product_info )) {
		?>
			<h2><?php  echo $product_info->name; ?></h2>
		
			<div class="box" id="planetPicture">[picture of Planet]</div>

			<div class="box" id="planetDescription">
				<?php echo $product_info->description; ?>
			</div>

			<?php if(isset( $product_attrs )) { ?>
				<div class="box" id="planetAttributes">
					<form>
						<ul>
						<?php 
						foreach($product_attrs as $attribute) {

							echo "<li><strong>$attribute->name: ";
							if($attribute->value != NULL) {
								echo $attribute->value;
							} else {
								print_input_for_value_range($attribute->attribute_id, $attribute->value_range);
							}
							echo "</strong><br/>$attribute->description</li>";
						}
						?>
						</ul>
					</form>
				</div>
			<?php } ?>
			
			<div class="box">
				<strong>Inventory quantity:</strong> <?php echo $product_info->inventory_quantity; ?><br/>
				<strong>Price:</strong> <?php echo $product_info->price; ?> credits
			</div>
			
			<div class="box" id="planetButtons" >			
			
			<a href="<?php
				$suffix = array("product_id" => $product_id, "action" => "add");
				echo get_href("shoppingCart", $suffix); ?>">Add to shopping Cart</a><br>
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
