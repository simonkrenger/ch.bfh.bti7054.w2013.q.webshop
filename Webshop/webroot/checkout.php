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
	switch($checkout_step) {
	case 1:
		echo "<h1>Checkout</h1>";
		global $shopuser;
		echo "Would you like to proceed to order as $shopuser->first_name?<br/><br/>";

		echo "<a href=\"" . get_href("checkout", array("step" => 2)) . "\">Yes, proceed</a><br/>";
		echo "<a href=\"" . get_href("checkout", array("logout" => "true")) . "\">No, log me out</a><br/>";
		break;
	case 2:
		echo "<h1>Checkout - Address</h1>";
		
		global $shopdb;
		
		
		
		echo "TODO: Confirm address here";
		// Idea: SELECT address from db
		// If there is an address for this user, show a dropdown containing these
		// Make a "action=reloadaddress" get_href($_GET["site"], array("action" => "reload"));
		//
		// Validate and continue

		echo "Continue here: <a href=\"" . get_href("checkout", array("step" => 3)) . "\">Step 3</a>";
		break;
	case 3:
		echo "<h1>Checkout - Review your order</h1>";
		// TODO: Add alert to notify user that he is entering a binding contract!
		// TODO: Display address
		$_SESSION["cart"]->displayFull();
		
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
	echo "<br/>Don't have an account? <a href=\"" . get_href("reg") . "\">Register Here</a>";
}

?>
			
			
			</div>
		<?php include('sidebar.php'); ?>
		</div>
				</div>