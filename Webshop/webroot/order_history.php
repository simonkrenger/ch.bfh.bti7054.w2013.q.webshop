<?php
/**
 * Order history
 */

global $shopdb;
global $shopuser;
$query = sprintf ( "SELECT COUNT(*) FROM `order` WHERE customer_id=%s", $shopuser->user_id );
$total_orders = $shopdb->get_var ( $query );

?>
<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			<h2>Order History</h2>
					<?php if(is_logged_in()) {
							if(isset($_GET["order_detail"])) {

								$output = print_order($_GET["order_detail"]);
								echo $output;
							} else { ?>
					<div id="ajax_div"></div>
			<div id="buttons">
				<p>Total: <?php echo $total_orders; ?> items</p>
				<input type="hidden" id="currentPosition" value="0" />

				<div id="leftbutton">
					<input type="button" id="prevbutton"
						value="Previous entries"
						onclick="orderhistory_update(this, <?php echo $total_orders; ?>)" />
				</div>
				<div id="rightbutton">
					<input type="button" id="nextbutton"
						value="Next entries"
						onclick="orderhistory_update(this, <?php echo $total_orders; ?>)" />
				</div>
				<script type="text/javascript">
										orderhistory_update(this);
							</script>
			</div>
					<?php }
					 } else { ?>
						<p>Not logged in. Please log in first!</p>
			<br /> <a href="<?php echo get_href("login"); ?>">Go to login page</a>
					<?php } ?>
				</div>
			<?php include('sidebar.php'); ?>
			</div>
</div>