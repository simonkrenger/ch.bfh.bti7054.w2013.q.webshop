<div id="rightsidebar">
	<div class="box">
		<div class="boxtitle">Shopping List</div>
		<div id="shoppinglist">
			<ul>
				<li>Planet1</li>
				<li>Planet4</li>
			</ul>
			<a href="shoppinglist.html">Checkout</a>
		</div>
	</div>

	<div class="box">
		<div class="boxtitle"><?php echo get_translation("MENU_LOGIN"); ?></div>
		<div id="login"><?php include(ABSPATH . '/modules/login/loginform.php'); ?></div>
	</div>
</div>