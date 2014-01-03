<?php 

if(isset($_GET['category'])) {
	// If the category is set, get all products of that category
	$category = $shopdb->escape($_GET['category']);
	$query = sprintf("SELECT product_id, name, product_picture, price, inventory_quantity FROM product WHERE product_category=%s", $category);
	$products = $shopdb->get_results($query);
	
	$query = sprintf("SELECT translation_string FROM product_category WHERE category_id=%s", $category);
	$category_title = get_translation($shopdb->get_row($query)->translation_string);
		
} else {
	// If category is not set, get all products
	$products = $shopdb->get_results("SELECT product_id, name, product_picture, price, inventory_quantity FROM product");
	$category_title = get_translation("ALL_PRODUCTS");
}


?>
		<div id="content">
			<div id="maincontent">
				<div id="contentarea">
				<h2><?php echo $category_title; ?></h2>
				<?php 
			
				foreach($products as $product) {
					// Calculate suffix (including 
					$prod_suffix = array('product_id' => $product->product_id);
					
					echo '<div class="product-listing-header"><a href="' . get_href('detail', $prod_suffix) . '">' . $product->name . '</a></div>';
					echo '<div class="separator"></div>';
				}
				?>
				
			</div>
			<?php include('sidebar.php'); ?>
	
		
</div>
</div>

		