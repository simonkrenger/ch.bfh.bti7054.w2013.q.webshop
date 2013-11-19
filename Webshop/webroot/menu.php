<div id="menu">
	<!-- <div class="menuentry" id="home"><a href="/index.html">Home</a></div> -->
				<?php

				global $shopdb;
				
				// Home link
				echo "<div class=\"menuentry\" id=\"home\"><a href=\"". get_href("home") ."\">" . get_translation ( "MENU_HOME" ) . "</a></div>";
				
				$categories = $shopdb->get_results ( "SELECT category_id,translation_string FROM product_category ORDER BY category_id" );
				foreach ( $categories as $category ) {
					echo "<div class=\"menuentry\" id=\"" . $category->translation_string . "\"><a href=\"". get_href("products", array("category" => $category->category_id)) . "\">" . get_translation ( $category->translation_string ) . "</a></div>";
				}
				
				// Shopping cart
				echo "<div class=\"menuentry\" id=\"shoppingcart\"><a href=\"". get_href("shoppingcart") . "\">" . get_translation ( "MENU_SHOPPINGCART") . "</a></div>";
				
				// Login
				if(is_logged_in()) {
					echo "<div class=\"menuentry\" id=\"login\"><a href=\"". get_href($_GET["site"], array("logout" => "true"), true) . "\">" . get_translation ( "MENU_LOGOUT" ) . "</a></div>";
				} else {
					echo "<div class=\"menuentry\" id=\"login\"><a href=\"". get_href("login") . "\">" . get_translation ( "MENU_LOGIN" ) . "</a></div>";
				}
				?>
			</div>