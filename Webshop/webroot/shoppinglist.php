
<?php

if (! isset ( $_SESSION ["cart"] ))
	$_SESSION ["cart"] = new ShoppingCart ();

if (isset ( $_GET ["product_id"] ))
	echo "product id ". $_GET ["product_id"] ;
	if ($_GET["product_id"] == 0 ){
		echo "product id is zero";
	$_SESSION ["cart"]->clear();
	}
	else {
		echo "product id is not zero";
	$_SESSION ["cart"]->addItem ( $_GET ["product_id"],1);
	}
	
?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php $_SESSION["cart"]->displayFull(); ?>
		
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>