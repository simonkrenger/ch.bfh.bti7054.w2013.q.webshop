<?php
function require_db() {
	global $shopdb;
	
	require_once('db/ez_sql_core.php');
	require_once('db/ez_sql_mysqli.php');
	
	if (! isset ( $shopdb )) {
		// The DB_* values were set in 'config.php'
		$shopdb = new ezSQL_mysqli ( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, 'utf8');
	}
}

function require_session() {
	session_start();
}

function require_login() {

	require_lang();

	
	// Login code
	if (isset ( $_POST ["islogin"] ) && isset ( $_POST ["username"] ) && isset ( $_POST ["password"] )) {
		global $shopdb;
	
		$cleaned_username = $shopdb->escape($_POST["username"]);
		$cleaned_password = $shopdb->escape($_POST["password"]);
	
		$query = sprintf("SELECT user_id FROM user WHERE username='%s' AND password=md5('%s') LIMIT 1", $cleaned_username, $cleaned_password);
		$login_user = $shopdb->get_row($query);
	
		if($login_user != NULL && isset($login_user->user_id)) {
			$_SESSION["logged_in"] = true;
			$_SESSION["user_id"] = $login_user->user_id;
		} else {
			header('Location: ' . get_href("login", array("login_failed" => 1)));
		}
	}
	
	// Logout code
	if(isset($_GET["logout"]) && is_logged_in()) {
		session_unset();
		session_destroy();
		header('Location: ' . get_href($_GET["site"], array(), true));
	}
}

function require_secure() {
	
	if (!is_logged_in()) {
		header('Location: ' . get_href("login"));
	}
}

function require_shoppingcart() {
	
	if (! isset ( $_SESSION ["cart"] ))
		$_SESSION ["cart"] = new ShoppingCart();
	
	if (isset ($_GET["action"])){
	
		switch ($_GET["action"]){
			case "add":
				if (isset ( $_GET ["product_id"] )){
					
					// Product ID is set
					$prod = new ShoppingCartProduct($_GET["product_id"]);
					
					// Fill in custom attributes from $_GET
					$custom_attrs = $prod->getNullAttributes();
					foreach($custom_attrs as $key => $value) {
						$get_key = "attribute_" . $value;
						$prod->addCustomAttribute($value, $_GET[$get_key]);
					}
					// At this point, the product has all attributes and custom attributes set
					
					// Add to shopping cart
					$_SESSION ["cart"]->addProduct($prod);
					
				}
				break;
			case "delete":
				if (isset ( $_GET ["product_id"] )){
					$_SESSION["cart"]->removeProduct($_GET["product_id"]);
				}
				break;
			case "clear":
				$_SESSION ["cart"]->clear();
				break;
		}
	}
}

function require_user() {
	global $shopuser;
	
	if ((! isset ( $shopuser )) && is_logged_in()) {
		$shopuser = new ShopUser($_SESSION["user_id"]);
	}
}

function is_logged_in() {
	if (isset($_SESSION["logged_in"]) && isset($_SESSION["user_id"])) {
		return true;
	}
	return false;
}

function is_admin_user() {
	require_user();
	
	global $shopuser;
	if($shopuser->role_id == 1) {
		// Role ID 1 equals an admin role
		return true;
	}
	return false;
}

function require_lang() {

	global $language;

	require_once('language.php');
		
	if (! isset ( $language )) {
		$language = get_language(); // Fr��nzi: Replace me!
		// Further reading: Read browser agent language (optional)
	}
}



/**
 * This method prints out an interactive slider or a dropdown box to customise
 * the given attribute. If the $attribute->value_range is a range (delimited by
 * "..."), then a slider is printed. Otherwise, a list is expected (delimited
 * by ",").
 * 
 * @param unknown $attribute
 */
function print_input_for_value_range($attribute) {
	if(strpos($attribute->value_range, "...")) {
		// Format is "<starting value>...<end value>"
		$min_max = explode("...", $attribute->value_range);
		echo "<div>";
		echo "<input type=\"range\" class=\"custom_attribute\" name=\"attribute_$attribute->attribute_id\" value=\"$attribute->default_value\" min=\"$min_max[0]\" max=\"$min_max[1]\" onchange=\"updateSlider(this)\">";
		echo "<span>$attribute->default_value</span>$attribute->value_unit</div>";
	} else if(strpos($attribute->value_range, ",")) {
		// Format is "option1,option2,option3"
		$options = explode(",", $attribute->value_range);
		echo "<select class=\"custom_attribute\" name=\"attribute_$attribute->attribute_id\" onchange=\"updateCartHref(this)\">";
		foreach($options as $option) {
			
			echo "<option value=\"$option\"";
			if($option == $attribute->default_value) {
				echo "selected";
			}
			echo">$option</option>";
		}
		echo "</select>";
	}
}

/**
 * Function to check if requested $_GET['site'] is an allowed site.
 *
 * @param unknown $site_id        	
 * @return string
 */
function get_safe_content_include($site_id) {
	$DEFAULT_SITE = 'home.php';
	
	if ($site_id != null) {
		$file = file ( "mapping.txt" );
		foreach ( $file as $line ) {
			$valid_site = explode ( ',', $line );
			if (strtolower($valid_site[0]) == $site_id) {
				return trim ( $valid_site [1] );
			}
		}
	}
	return $DEFAULT_SITE;
}

function get_href($site, $suffix=array(), $preserve=false) {
	$params = $suffix;
	
	if($preserve) {
		$params = array_merge($_GET, $params);
	}
	
	$params = array_replace($params, array("site" => strtolower($site)));
	return "index.php?" . http_build_query($params);
}

/**
 * Function to get a Parameter form $_GET Array.
 * @param unknown $name
 * @param unknown $default
 * @return string|unknown
 */
function get_param($name, $default) {
	if (isset($_GET[$name])) {
		return urldecode($_GET[$name]);
	}
	else{
		return $default;
	}
}

/**
 * Function to add a parameter to $_GET Array
 * @param unknown $url
 * @param unknown $name
 * @param unknown $value
 * @param string $sep
 * @return string
 */
function add_param($url, $name, $value, $sep="&") {
	$new_url = $url.$sep.$name."=".urlencode($value);
	return $new_url;
}

/**
 * The Function to get all the attributes of a Product out of the DB
 * @param unknown $id > is a Product ID
 * @return Ambigous <NULL, multitype:>
 */
function getProductInformation($id){
	global $shopdb;
	$product_id = $shopdb->escape($id);
	$query = sprintf ( "SELECT product_id, name, product_picture, description, price, inventory_quantity FROM product WHERE product_id=%s", $product_id  );
	return $shopdb->get_row( $query );
}

function print_form_fields($form_file) {
	global $language;
	
	$form = file ( ABSPATH . $form_file );
	
	$formfields = array ();
	foreach ( $form as $line ) {
		array_push ( $formfields, explode ( ',', $line ) );
	}
	
	foreach ( $formfields as $entry ) {
		
		// If the $_POST variable has an entry for this, go for it!
		if(isset($_POST[$entry[0]])) {
			$preset_value = $_POST[$entry[0]];
		} else {
			// Else, fall back to translation
			$preset_value = get_translation ($entry[1]);
		}
		
		echo "<div class=\"formField\"> <label for =\"" . $entry [0] . "\">" . get_translation ( $entry [1] ) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry [0] . "\" size=\"" . $entry [3] . "\" maxlength=\"" . $entry [4] . "\" id=\"" . $entry [0] . "\" placeholder =\"" . get_translation ( "$entry[1]" ) ."\" value =\"" . $preset_value . "\" ></input></div>";
	}
}

function db_insert_galaxy($name) {
	global $shopdb;
	
	// Register galaxy
	$clean_galaxy_name = trim($shopdb->escape($name));
	$query = sprintf("SELECT galaxy_id FROM galaxy WHERE lower(name)=lower('%s') LIMIT 1;", $clean_galaxy_name);
	$galaxy_id = $shopdb->get_var($query);
	if($galaxy_id == NULL) {
		// Galaxy does not yet exist, insert it
		$query = sprintf("INSERT INTO galaxy (name) VALUES ('%s');", $clean_galaxy_name);
		$result = $shopdb->query($query);
		if($result) {
			$query = sprintf("SELECT galaxy_id FROM galaxy WHERE lower(name)=lower('%s') LIMIT 1;", $clean_galaxy_name);
			$galaxy_id = $shopdb->get_var($query);
		} else {
			$shopdb->debug();
			return null;
		}
	}
	return $galaxy_id;
}

function db_insert_planet($name) {
	global $shopdb;
	
	// Register planet
	$clean_planet_name = trim($shopdb->escape($name));
	$query = sprintf("SELECT planet_id FROM planet WHERE lower(name)=lower('%s') LIMIT 1;", $clean_planet_name);
	$planet_id = $shopdb->get_var($query);
	if($planet_id == NULL) {
		// Planet does not yet exist, insert it
		$query = sprintf("INSERT INTO planet (name) VALUES ('%s');", $clean_planet_name);
		$result = $shopdb->query($query);
		if($result) {
			$query = sprintf("SELECT planet_id FROM planet WHERE lower(name)=lower('%s') LIMIT 1;", $clean_planet_name);
			$planet_id = $shopdb->get_var($query);
		} else {
			$shopdb->debug();
			return null;
		}
	}
	return $planet_id;
}

function db_insert_address($street, $zipcode, $city, $country, $planet_id, $galaxy_id) {
	global $shopdb;
	
	$address_name = 'addr_' . time();
	
	$clean_street_name = $shopdb->escape($street);
	$clean_zipcode = $shopdb->escape($zipcode);
	$clean_city = $shopdb->escape($city);
	$clean_country = $shopdb->escape($country);
	
	$query = sprintf("INSERT INTO address (address_name, street, zipcode, city, country, galaxy_id, planet_id) VALUES ('%s','%s','%s','%s','%s',%s,%s);",
			$address_name, $clean_street_name, $clean_zipcode, $clean_city, $clean_country, $galaxy_id, $planet_id);
	
	$result = $shopdb->query($query);
	if($result) {
		$query = sprintf("SELECT address_id FROM address WHERE address_name='%s' LIMIT 1;", $address_name);
		$address_id = $shopdb->get_var($query);
		return $address_id;
	} else {
		$shopdb->debug();
		return null;
	}
	
}

?>
