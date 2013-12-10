<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<h1>Shopping Cart</h1>
		
		<table class="cartFull">
		
		<tr>
		<td class="cartField">Name</td>
		<td class="cartField">Description</td>
		<td class="cartField">Price</td>
		<td class="cartField">Quantity</td>
		<td class="cartField">Total</td>
		</tr>
		
		<?php $_SESSION["cart"]->displayFull(); ?>
		
		</table>

		
		
		
		<a href="<?php
				$suffix = array( "action" => "clear");
				echo get_href("shoppingCart", $suffix); ?>">Clear cart</a>
			
			
		
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>
