
		<div id="content">
			<div id="maincontent">
				
				<?php 
				/** Dummy query */
					$products = $shopdb->get_results("SELECT name, product_picture, price, inventory_quantity FROM product");
					foreach($products as $product) {
						echo '<div class="product-listing-header">' . $product->name . '</div>';
						echo '<div class="separator"></div>';
					}
				?>
				
			</div>
			<?php include('sidebar.php'); ?>
		</div>