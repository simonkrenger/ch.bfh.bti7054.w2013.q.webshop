
		<div id="content">
			<div id="maincontent">
				
				<?php 
				/** Dummy query */
				if(isset($_GET['category'])) {
					$category = $_GET['category'];
					$query = sprintf("SELECT name, product_picture, price, inventory_quantity FROM product WHERE product_category=%s", $category);
					$products = $shopdb->get_results($query);
					
				} else {
					$products = $shopdb->get_results("SELECT name, product_picture, price, inventory_quantity FROM product");
				}
				
				foreach($products as $product) {
					echo '<div class="product-listing-header">' . $product->name . '</div>';
					echo '<div class="separator"></div>';
				}
				?>
				
			</div>
			<?php include('sidebar.php'); ?>
		</div>