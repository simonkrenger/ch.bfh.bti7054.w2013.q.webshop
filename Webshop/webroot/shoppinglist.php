
<?php

if (! isset ( $_SESSION ["cart"] ))
	$_SESSION ["cart"] = new Cart ();
if (isset ( $_GET ["product_id"] ))
	if ($_GET["product_id"] == 0 ){
	$_SESSION ["cart"]->clear();
	}
	else {
	$_SESSION ["cart"]->addItem ( $_GET ["art"], $_GET ["num"] );}
	
?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php $_SESSION["cart"]->display(); ?>
		
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>