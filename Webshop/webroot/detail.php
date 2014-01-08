<?php
if (isset ( $_GET ['product_id'] )) {
	// Clean product ID
	$product_id = $shopdb->escape ( $_GET ['product_id'] );
	
	// Get basic product information
	$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
	$product_info = $shopdb->get_row ( $query );
	
	// Get all attributes for product
	$query = sprintf ( "SELECT pa.attribute_id, pa.name, pav.attribute_value_id, pa.description, pav.value, pa.value_range, pa.value_unit, pa.default_value FROM product p LEFT JOIN product_attribute_value pav ON pav.product_id = p.product_id RIGHT JOIN product_attribute pa ON pav.product_attribute_id = pa.attribute_id WHERE pav.product_id=%s", $product_id );
	$product_attrs = $shopdb->get_results ( $query );
}

?>
<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php
		if (isset ( $product_info )) {
			?>
			<h2><?php  echo $product_info->name; ?></h2>

			<div class="box" id="planetPicture">
			<?php 
				if($product_info->product_picture != NULL) {
					echo '<img src="images/product_pictures/' . $product_info->product_picture . '" alt="Product picture" width="200" height="200" />';
				} else {
					// Fallback when there is no image defined (field is NULL)
					echo '<img src="images/product_pictures/no_image.png" alt="Product picture" width="200" height="200" />';
				}
			?>
			</div>

			<div class="box" id="planetDescription">
				<?php echo $product_info->description; ?>
			</div>

			<?php if(isset( $product_attrs )) { ?>
				<div class="box" id="planetAttributes">
				<form>
					<ul>
						<?php
						// Array to hold the values of any custom attributes
						$custom_attrs_suffix = array();
				
						foreach ( $product_attrs as $attribute ) {
							// Loop through each attribute
							echo "<li><strong>$attribute->name: </strong>";
							if ($attribute->value != NULL) {
								// The attribute has a preset value for this product
								echo $attribute->value . $attribute->value_unit;
							} else {
								// The attribute is customizable
								// Display a slider or dropdown
								print_input_for_value_range ( $attribute );
								
								// Since these are custom attributes, add the initial value of those to the "add to cart" link
								$custom_attrs_suffix = array_merge ( $custom_attrs_suffix, array (
										"attribute_$attribute->attribute_id" => urlencode($attribute->default_value)
								) );
							}
							echo "<br/>$attribute->description</li>";
						}
				?>
						</ul>
				</form>
			</div>
			<?php } ?>
			
			<div class="box">
				<strong>Inventory quantity:</strong> <?php echo $product_info->inventory_quantity; ?><br/><br>
				<strong>Price:</strong> <?php echo $product_info->price; ?> credits
			</div>

			<div class="box" id="planetButtons" >                        

                        <a id="addtocartlink" href="<?php
                                $suffix = array("product_id" => $product_id, "action" => "add");
                                
                                // Add custom attributes values
                                $suffix = array_merge($suffix, $custom_attrs_suffix);
                                
                                echo get_href("shoppingcart", $suffix); ?>">Add to shopping Cart</a><br/>
                        </div>
		<?php
		} else {
			?>
		
		<div class="box" id="planetPicture">Error: No product_id provided.</div>
		
		<?php
		}
		?>
			</div>
			<?php include('sidebar.php'); ?>
		</div>
	</div>