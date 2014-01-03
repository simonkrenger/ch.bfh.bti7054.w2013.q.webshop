<?php 

if(isset($_GET["action"])) {
	if($_GET["action"] == "doregister") {
		global $shopdb;
		
		// Register planet
		$clean_planet_name = trim($shopdb->escape($_POST["planet"]));
		$query = sprintf("SELECT planet_id FROM planet WHERE lower(name)=lower('%s') LIMIT 1;", $clean_planet_name);
		$planet_id = $shopdb->get_var($query);
		if($planet_id == NULL) {
			// Planet does not yet exist, insert it
			$query = sprintf("INSERT INTO planet (name) VALUES ('%s');", $clean_planet_name);
			$result = $shopdb->query($query);
			if($result) {
				$output .= "Planet '$clean_planet_name' entered.<br/>";
				$query = sprintf("SELECT planet_id FROM planet WHERE lower(name)=lower('%s') LIMIT 1;", $clean_planet_name);
				$planet_id = $shopdb->get_var($query);
			}
		}
		
		// Register galaxy
		$clean_galaxy_name = trim($shopdb->escape($_POST["galaxy"]));
		$query = sprintf("SELECT galaxy_id FROM galaxy WHERE lower(name)=lower('%s') LIMIT 1;", $clean_galaxy_name);
		$galaxy_id = $shopdb->get_var($query);
		if($galaxy_id == NULL) {
			// Galaxy does not yet exist, insert it
			$query = sprintf("INSERT INTO galaxy (name) VALUES ('%s');", $clean_galaxy_name);
			$result = $shopdb->query($query);
			if($result) {
				$output .= "You are the first visitor from galaxy '$clean_galaxy_name', welcome!<br/>";
				$query = sprintf("SELECT galaxy_id FROM galaxy WHERE lower(name)=lower('%s') LIMIT 1;", $clean_galaxy_name);
				$galaxy_id = $shopdb->get_var($query);
			}
		}
		
		// Register address
		$address_name = 'addr_' . time();
		
		$clean_street_name = $shopdb->escape($_POST["street"]);
		$clean_zipcode = $shopdb->escape($_POST["zipcode"]);
		$clean_city = $shopdb->escape($_POST["city"]);
		$clean_country = $shopdb->escape($_POST["country"]);
		
		$query = sprintf("INSERT INTO address (address_name, street, zipcode, city, country, galaxy_id, planet_id) VALUES ('%s','%s','%s','%s','%s',%s,%s);", 
				$address_name, $clean_street_name, $clean_zipcode, $clean_city, $clean_country, $galaxy_id, $planet_id);
		
		$result = $shopdb->query($query);
		if($result) {
			$query = sprintf("SELECT address_id FROM address WHERE address_name='%s' LIMIT 1;", $address_name);
			$address_id = $shopdb->get_var($query);
			$output .= "Address entered, ID is $address_id.<br/>";
		}
		
		
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
			$output .= "User successfully registered, ID is $user_id.<br/>";
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