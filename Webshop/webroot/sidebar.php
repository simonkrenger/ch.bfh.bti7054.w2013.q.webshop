<div id="rightsidebar">
	<div class="box">
		<div class="boxtitle"><h4>Shopping List</h4></div>
		<div id="shoppinglist">
			<ul>
			<!-- TODO: change to displaySmall when function is implemented -->
<?php $_SESSION["cart"]->displayFull(); ?> 
			</ul>
			<a href="<?php echo get_href("checkout"); ?>">Checkout</a>
		</div>
	</div>

	<div class="box">
		<div class="boxtitle"><h4><?php echo get_translation("MENU_LOGIN"); ?></h4></div>
		<?php if(!is_logged_in()) { ?>
			<div id="login"><?php include(ABSPATH . '/modules/login/loginform.php'); ?></div>
		<?php } else {
			?>
			<div id="login">
				<p><?php 
				global $shopuser;
				echo "Welcome back " . $shopuser->first_name . "!";
				?></p>
				
				<?php if(is_admin_user()) {
					// If user is an admin, display admin link
					echo '<p><a href="' . get_href("admin") .'">Admin</a></p>';
				}
				?>
				
				<p><a href="<?php echo get_href($_GET["site"] , array("logout" => "true"), true); ?>">Logout</a></p>
			</div>
		<?php }?>
	</div>
</div>