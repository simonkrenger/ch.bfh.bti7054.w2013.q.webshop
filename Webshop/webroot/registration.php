<?php 
/**
 * Registration page
 * 
 */
if(isset($_GET["action"])) {
	if($_GET["action"] == "doregister") {
		// Action is set (variables in POST)
		global $shopdb;
		
		// Register planet
		$planet_id = db_insert_planet($_POST["planet"]);
		
		// Register galaxy
		$galaxy_id = db_insert_galaxy($_POST["galaxy"]);
		
		// Register address
		$address_id = db_insert_address($_POST["street"], $_POST["zipcode"], $_POST["city"], $_POST["country"], $planet_id, $galaxy_id);
		
		// Register user
		$clean_username = $shopdb->escape($_POST["registration_username"]);
		$hashed_password =  md5($_POST["registration_password"]);
		$clean_email = $shopdb->escape($_POST["email"]);
		$clean_firstname = $shopdb->escape($_POST["firstname"]);
		$clean_lastname = $shopdb->escape($_POST["lastname"]);
		
		$query = sprintf("INSERT INTO user (username, password, email, first_name, last_name, address_id) VALUES ('%s','%s','%s','%s','%s','%s');",
				$clean_username, $hashed_password, $clean_email, $clean_firstname, $clean_lastname, $address_id);
		
		$result = $shopdb->query($query);
		if($result) {
			$query = sprintf("SELECT user_id FROM user WHERE username = '%s'", $clean_username);
			$user_id = $shopdb->get_var($query);
			$output .= "User successfully registered, User ID is $user_id.<br/>";
		} else {
			$shopdb->debug();
		}
	}
}
?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<?php if(! isset($_GET["action"])) {
			// Show form (no action set)
		?>
		
			<form class="form" name="registrationForm" id="registrationForm"
				action="<?php echo get_href("register", array("action" => "doregister")); ?>" method="post"
				onreset="resetForm()">

				<div class="form">

					<?php
						echo "<h2>User Details</h2>";
						print_form_fields ( "modules/forms/userForm.txt" );
						
						echo "<h2>Address Details</h2>";
						print_form_fields ( "modules/forms/addressForm.txt" )
					?>
	
					<div class="button">
						<input type="button" name="submitted"
							value="<?php echo get_translation("FORM_REG");?>"
							onclick="verifyRegistrationForm()" />
					</div>
				</div>
			</form>
			
			<?php 
			} else {
				// Action was set, so output from above
				if(isset($address_id) && isset($planet_id) && isset($galaxy_id) && isset($user_id)) {
					echo "<h1>Registration successful</h1>";
					echo "<p><a href=\"" . get_href("login") . "\">Click here</a> to log in</p>";
				} else {
					echo "<h1>Registration failed</h1>";
					echo "<p>Please review the output below</p>";
				}
				echo "Additional information:<br/>";
				echo "<p>$output</p>";
			}
		?>
		</div>	
	<?php include('sidebar.php'); ?>
	</div>
</div>