		<div id="content">
			<div id="marketing">
				<div class="marketing-text">
					<?php echo get_translation("MARKETING_CLAIM_BIG"); ?>
					<div class="marketing-subtext">
						<?php echo get_translation("MARKETING_CLAIM_SUBTEXT"); ?> <a href="<?php echo get_href("products",array("category" => 2)) ?>"><?php echo get_translation("MARKETING_FIND_OUT_MORE"); ?></a>
					</div>
				</div>
			</div>
			<div id="maincontent">
			<?php 
			
			$categories = $shopdb->get_results ( "SELECT category_id,translation_string FROM product_category ORDER BY category_id" );
			foreach ( $categories as $category ) {
				echo "<button class=\"categorytile\"><a href=\"". get_href("products", array("category" => $category->category_id)) . "\">" . get_translation ( $category->translation_string ) . "</a></button>";
			}
			
			?>
			</div>
		</div>