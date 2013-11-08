
		<div id="content">
			<div id="maincontent">
				<div id="contentarea">
				<?php 
				/** Dummy query */
				if(isset($_GET['category'])) {
					$category = $shopdb->escape($_GET['category']);
					$query = sprintf("SELECT product_id, name, product_picture, price, inventory_quantity FROM product WHERE product_category=%s", $category);
					$products = $shopdb->get_results($query);
					
				} else {
					$products = $shopdb->get_results("SELECT name, product_picture, price, inventory_quantity FROM product");
				}
				
				foreach($products as $product) {
					// Calculate suffix (including 
					$prod_suffix = '&product_id=' . $product->product_id;
					
					echo '<div class="product-listing-header"><a href="' . get_href('detail', $prod_suffix) . '">' . $product->name . '</a></div>';
					echo '<div class="separator"></div>';
				}
				?>
				
			</div>
			</div>
			<?php include('sidebar.php'); ?>
		</div>