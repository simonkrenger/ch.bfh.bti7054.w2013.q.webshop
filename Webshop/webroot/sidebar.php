
<div id="rightsidebar">
	<div class="box">
		<div class="boxtitle"><h4><?php echo get_translation("MENU_SHOPPINGCART"); ?></h4></div>
		<div id="shoppinglist">
			<?php
			$cart = $_SESSION["cart"];
			
			$cart->displaySmall();
			
			if(!$cart->is_empty()) {
				echo '<a href="' . get_href("checkout") . '">';
				echo get_translation("SHOPPINGCART_CHECKOUT");
				echo '</a>';
			}?> 
		</div>
	</div>

	<div class="box">
		<div class="boxtitle"><h4><?php echo get_translation("MENU_LOGIN"); ?></h4></div>
		<?php if(!is_logged_in()) { ?>
			<div id="loginbox">
				<?php
				include(ABSPATH . '/modules/login/loginform.php');
				echo "<p><a href=\"" . get_href('register') . "\">" . get_translation("FORM_REG") . "</a></p>";
				?>
			</div>
		<?php } else {
			?>
			<div id="loginbox">
				<p><?php 
				global $shopuser;
				echo "Welcome back " . $shopuser->first_name . "!";
				?></p>
				
				<?php if(is_admin_user()) {
					// If user is an admin, display admin link
					echo '<p><a href="' . get_href("admin") .'">Admin Area</a></p>';
				}
				?>
				
				<p><a href="<?php echo get_href($_GET["site"] , array("logout" => "true"), true); ?>">Logout</a></p>
			</div>
		<?php }?>
	</div>
</div>

