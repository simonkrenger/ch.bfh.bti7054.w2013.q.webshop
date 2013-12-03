<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php $_SESSION["cart"]->displayFull(); ?>
		
		<a href="<?php
				$suffix = array( "action" => "clear");
				echo get_href("shoppingCart", $suffix); ?>">Clear cart</a>
			
			
		
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>