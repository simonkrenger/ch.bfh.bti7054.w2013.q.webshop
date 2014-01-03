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

			<div id="orderFormDiv">

				<div id="heading">order form</div>
				
					<form class="form" name="orderForm" id="orderForm"
						action="<?php
						$suffix = array ();
						echo get_href ( "sendOrder", $suffix, true );
						?>"
						method="post" onsubmit="submitOrderForm()" onreset="resetOrderForm()">
					
					<div class="form">
					
							<?php print_form_fields("modules/forms/orderForm.txt"); ?>
						
							<div class ="button">
								<input type="button" name="submitted" value="Order now!"
									onclick="verifyOrderForm()" />
							</div>
						</div>
					</form>
				
			</div>

			<?php } else { ?>
			<div class="box">Error: No product_id provided!</div>
			<?php } ?>
		</div>

<?php include('sidebar.php'); ?>
