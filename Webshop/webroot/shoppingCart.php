
<?php

if (! isset ( $_SESSION ["cart"] ))
	$_SESSION ["cart"] = new ShoppingCart ();

if (isset ($_GET["action"])){
	
	switch ($_GET["action"]){
		case "add":
			if (isset ( $_GET ["product_id"] )){
				$_SESSION ["cart"]->addItem ( $_GET ["product_id"],1);
			}
			break;
		case "clear":
			$_SESSION ["cart"]->clear();
			break;
	}
}
	
?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<h1>Shopping Cart</h1>
		
		<table class="cartFull">
		
		<tr>
		<td>Name</td>
		<td>Description</td>
		
		</tr>";
		
		</table>
		<?php $_SESSION["cart"]->displayFull(); ?>
		
		
		
		<a href="<?php
				$suffix = array( "action" => "clear");
				echo get_href("shoppingCart", $suffix); ?>">Clear cart</a>
			
			
		
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>