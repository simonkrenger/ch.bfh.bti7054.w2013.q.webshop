
		<div id="content">
			<div id="maincontent">
				<div id="contentarea">
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
					//TODO: Make this link dynamic!
					echo '<div class="product-listing-header"><a href="' . get_href('detail') . '">' . $product->name . '</a></div>';
					echo '<div class="separator"></div>';
				}
				?>
				
			</div>
			</div>
			<?php include('sidebar.php'); ?>
		</div>