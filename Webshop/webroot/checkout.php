<?php 

/* 1. Check if user is logged in
 *    If not,  present two options: Register or login
 * 2. User should now enter his address
 *    - After address is entered, it is saved into the database
 * 3. User should be able to review his order, confirm
 * 4. Write order to database
 *    - Show confirmation dialog
 *    - Generate PDF
 *    - Send out e-mail
 */

// Set initial step value
if(! isset($_GET["step"])) {
	$checkout_step = 1;
} else {
	$checkout_step = $_GET["step"];
}
?>
	<div id="content">
		<div id="maincontent">
			<div id="contentarea">
			
<?php 

if( is_logged_in()) {
	global $shopuser;
	global $shopdb;
	
	switch($checkout_step) {
	case 1:
		echo "<h1>" . get_translation("SHOPPINGCART_CHECKOUT") . "</h1>";
		
		echo sprintf(get_translation("CHECKOUT_PROCEED_AS"), $shopuser->first_name). "<br/><br/>";
		
		echo "<div class=\"box\" id=\"planetButtons\">";
		echo "<a href=\"" . get_href("checkout", array("step" => 2)) . "\">" . get_translation("CHECKOUT_YES") . "</a><br/>";
		echo "</div>";
		echo "<div class=\"box\" id=\"planetButtons\">";
		echo "<a href=\"" . get_href("checkout", array("logout" => "true")) . "\">" . get_translation("CHECKOUT_NO") . "</a><br/>";
		echo "</div>";
		break;
	case 2:
		// In this step, we want to get the users address
		echo "<h1>" . get_translation("CHECKOUT_ADDRESS") . "</h1>";
		
		if(isset($_GET["action"])) {
			// User either reset his address or submitted a form
			if($_GET["action"] == "doeditaddress") {
				// Register planet
				$planet_id = db_insert_planet($_POST["planet"]);
				
				// Register galaxy
				$galaxy_id = db_insert_galaxy($_POST["galaxy"]);
				
				// Register address
				$address_id = db_insert_address($_POST["street"], $_POST["zipcode"], $_POST["city"], $_POST["country"], $planet_id, $galaxy_id);
				
				$query = sprintf("UPDATE user SET address_id=%s WHERE user_id=%s", $address_id, $shopuser->user_id);
				$shopdb->query($query);
				
			} else if($_GET["action"] == "resetaddress") {
				// User asked to reset his address
				$query = sprintf("UPDATE user SET address_id=NULL WHERE user_id=%s", $shopuser->user_id);
				$shopdb->query($query);
			}
		}

		$query = sprintf("SELECT address_id FROM user WHERE user_id=%s", $shopuser->user_id);
		$address_id = $shopdb->get_var($query);
		if($address_id != NULL) {
			echo "<p>" . get_translation("CHECKOUT_CUR_ADDRESS") . "</p>";
						
			print_address($address_id);
			echo "<div class=\"box\" id=\"planetButtons\">";
			echo "<a href=\"" . get_href("checkout", array("step" => 3)) . "\">" . get_translation("CHECKOUT_CONTINUE_ADDR") . "</a>";
			echo "</div>";
			echo "<div class=\"box\" id=\"planetButtons\">";
			echo "<a href=\"" . get_href("checkout", array("step" => 2, "action" => "resetaddress")) . "\">" . get_translation("CHECKOUT_CHANGE_ADDR") . "</a>";
			echo "</div>";
			
		} else {
			?>
			<p><?php echo get_translation("CHECKOUT_PROVIDE_ADDR"); ?></p>
			<form class="form" name="registrationForm" id="registrationForm"
					action="<?php echo get_href("checkout", array("step" => 2, "action" => "doeditaddress")); ?>" method="post"
							onreset="resetForm()">
				<div class="form">
					<?php print_form_fields ( "modules/forms/addressForm.txt" ); ?>
					<div class="button">
						<input type="button" name="submitted"
							value="<?php echo get_translation("FORM_REG");?>"
							onclick="verifyRegistrationForm()" />
					</div>
				</div>
			</form>
		<?php
		}
		break;
	case 3:
		echo "<h1>" . get_translation("CHECKOUT_REVIEW_ORDER") . "</h1>";
		echo "<p>" . get_translation("CHECKOUT_REVIEW_THIS") . "</p>";
		$shoppingcart = $_SESSION["cart"];
		$shoppingcart->displayFull();
		
		echo "<p>" . get_translation("CHECKOUT_CONTACT_ADDR") . "</p>";
		
		$query = sprintf("SELECT address_id FROM user WHERE user_id=%s", $shopuser->user_id);
		$address_id = $shopdb->get_var($query);
		print_address($address_id);
		
		echo "<p>" . get_translation("CHECKOUT_REVIEW_CONFIRM") . "</p>";
		
		?>
		
		
		<form id="formcheckoutreview" action="<?php echo get_href("checkout", array("step" => 4)); ?>"
			method="post" >
			<input type="hidden" name="reviewconfirm" value="true" />
			<input type="button" value="<?php echo get_translation("CHECKOUT_ORDER_BUTTON"); ?>" onclick="displayOrderConfirmation('formcheckoutreview')"/>
		</form>
		
		<?php
		break;
	case 4:
		echo "<h1>" . get_translation("CHECKOUT_CONFIRMATION") . "</h1>";
		
		if(isset($_POST["reviewconfirm"]) && $_POST["reviewconfirm"] == "true") {
		
			// Create order
			$query = sprintf("SELECT address_id FROM user WHERE user_id=%s", $shopuser->user_id);
			$address_id = $shopdb->get_var($query);
			$order_id = db_insert_order($shopuser->user_id, $address_id);
			
			// Create order positions
			$shoppingcart = $_SESSION["cart"];
			$items = $shoppingcart->getAllItems();
			$quantities = $shoppingcart->getQuantities();
			
			$success = true;
			
			// Iterate over all items in the cart
			foreach($items as $item) {

				$prod_info = $item->getProductInfo();

				// For each item, add an order position
				if(db_insert_order_detail($order_id, $prod_info->product_id, 
					$quantities[$prod_info->product_id])) {
					// Ok, now add the custom attributes to these positions
					
					// First, find out which custom attributes this product has
					// Do this by creating a vanilla product and check for NULL values
					$p = new ShopProduct($prod_info->product_id);
					$custom_attrs = $p->getNullAttributes();
					
					// These are the attributes that can be customized, add these to the DB
					foreach($custom_attrs as $key => $value) {
						if(db_insert_order_detail_attribute($order_id, $prod_info->product_id, 
							$value, $item->attributes[$value])) {
						} else {
							$success = false;
						}
					}
					
				} else {
					$success = false;
				}
			}
			
			if($success) {
				
				
				// Get the order summary
				$order_summary = print_order($order_id);
				
				echo "Successfully placed order (Order ID $order_id)!";
				
				//clear cart
				$shoppingcart->clear();
				
				// Send the order summary as an e-mail
				$mail_message = "<html><head><title>Order Summary</title><head><body><h1>Thank you for your order!</h1>$order_summary</body></html>";
				$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				if(mail($shopuser->email, "PlanetShop: Order Confirmation", $mail_message, $headers)) {
					echo "<br/>Sent confirmation e-mail to $shopuser->email<br/>";
				}
				
				// Print the order summary
				echo $order_summary;
				echo "<div class=\"separator\"></div>";
				echo "<div class=\"box\" id=\"planetButtons\">";
				echo "<a href=\"" . get_href("printorder", array("order_id" => $order_id)) . "\">Print order</a>";
				echo "</div>";
			} else {
				echo "There was an error placing the order, please retry!";
			}

		} else {
			echo "<p>You did not confirm your order, aborting. Please try again</p>";
		}
		break;
	default:
		echo "<h1>Checkout - Error</h1>";
		echo "Something went wrong, please try again.";
		break;
	}
} else {
	echo "You are not logged in. Please log in:";
	include(ABSPATH . '/modules/login/loginform.php');
	echo "<br/>Don't have an account? <a href=\"" . get_href("register") . "\">Register Here</a>";
}

?>
			</div>
		<?php include('sidebar.php'); ?>
		</div>
	</div>
