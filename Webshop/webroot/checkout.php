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
		echo "<h1>Checkout</h1>";
		
		echo "Would you like to proceed to order as $shopuser->first_name?<br/><br/>";

		echo "<a href=\"" . get_href("checkout", array("step" => 2)) . "\">Yes, proceed</a><br/>";
		echo "<a href=\"" . get_href("checkout", array("logout" => "true")) . "\">No, log me out</a><br/>";
		break;
	case 2:
		// In this step, we want to get the users address
		echo "<h1>Checkout - Address</h1>";
		
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
			echo "<p>Your current address is set to:</p>";
						
			$query = sprintf("SELECT a.street, a.zipcode, a.city, a.country, p.name AS pname, g.name AS gname FROM address a JOIN planet p ON a.planet_id = p.planet_id JOIN galaxy g ON a.galaxy_id = g.galaxy_id WHERE a.address_id=%s LIMIT 1", $address_id);
			$address = $shopdb->get_row($query);
			
			echo "<ul>";
				echo "<li>First Name, Last Name: $shopuser->first_name, $shopuser->last_name</li>";
				echo "<li>Street: $address->street</li>";
				echo "<li>Postal code: $address->zipcode</li>";
				echo "<li>City: $address->city</li>";
				echo "<li>Country: $address->country</li>";
				echo "<li>Planet: $address->pname</li>";
				echo "<li>Galaxy: $address->gname</li>";
			echo "</ul>";

			echo "<p>Continue with this address: <a href=\"" . get_href("checkout", array("step" => 3)) . "\">Step 3</a></p>";
			echo "<p><a href=\"" . get_href("checkout", array("step" => 2, "action" => "resetaddress")) . "\">Change address</a></p>";
	
		} else {
			?>
			<p>Please provide your address</p>
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
		echo "<h1>Checkout - Review your order</h1>";
		// TODO: Add alert to notify user that he is entering a binding contract!
		// TODO: Display address
		$_SESSION["cart"]->displayFull();
		
		?>
		
		<form id="formcheckoutreview" action="<?php echo get_href("checkout", array("step" => 4)); ?>"
			method="post" onsubmit="submitOrderForm()">
			<input type="hidden" name="reviewconfirm" value="true" />
			<input type="button" value="Order!" />
		</form>
		
		<?php
		
		echo "Continue here: <a href=\"" . get_href("checkout", array("step" => 4)) . "\">Step 4</a>";
		break;
	case 4:
		echo "<h1>Checkout - Confirmation</h1>";
		
		
		
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