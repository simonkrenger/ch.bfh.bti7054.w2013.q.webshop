<?php 

if (isset ( $_GET ['product_id'] )) {
	$product_id = $shopdb->escape($_GET ['product_id']);
	$query = sprintf ( "SELECT product_id, name, product_picture, price, inventory_quantity FROM product WHERE product_id=%s", $product_id );
	$product_info = $shopdb->get_row( $query );
}

?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			
			<?php if(isset($product_info)) { ?>
			<div id="orderSummary">
				<div id="heading">order summary</div>
				<div class="box"> The Planet you order: <?php echo $product_info->name; ?></div>
			</div>

			<div id="orderForm">

				<div id="heading">order form</div>
				<?php include(ABSPATH . 'modules/order/orderForm.php'); ?>
				
			</div>

			<?php } else { ?>
			<div class="box">Error: No product_id provided!</div>
			<?php } ?>
		</div>
	</div>
<?php include('sidebar.php'); ?>
</div>