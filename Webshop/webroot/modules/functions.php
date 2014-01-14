<?php
/**
 * Main functions file for PlanetShop
 * 
 * This file contains most of the functions globally defined and used.
 */

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
					$prod = new ShopProduct($_GET["product_id"]);
					
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

function require_lang() {

	global $language;

	require_once('language.php');

	if (! isset ( $language )) {
		$language = get_language(); // Fränzi: Replace me!
		// Further reading: Read browser agent language (optional)
	}
}


/**
 * Function to determine if a user is logged in
 * 
 * @return boolean Returns TRUE if the user is logged in and FALSE if the user
 * is not logged in.
 */
function is_logged_in() {
	if (isset($_SESSION["logged_in"]) && isset($_SESSION["user_id"])) {
		return true;
	}
	return false;
}

/**
 * Checks if the current user is an admin user (has a "role_id" of "1").
 * @return boolean Returns TRUE if the current user is an admin user, else this
 * function returns FALSE.
 */
function is_admin_user() {
	require_user();
	
	global $shopuser;
	if($shopuser->role_id == 1) {
		// Role ID 1 equals an admin role
		return true;
	}
	return false;
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
				echo " selected";
			}
			echo">$option</option>";
		}
		echo "</select>";
	}
}

/**
 * Function to check if requested $_GET['site'] is an allowed site.
 *
 * @param string $site_id This is a site ID (defined in "mapping.txt")
 * @return string returns the PHP file to be included
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

/**
 * Method to get a correct link to navigate within the site. Use this method to
 * generate a valid link on this site. Returns a hyperlink in the form of
 * "index.php?site=<site-id>&<optional-arguments>".
 * 
 * @param string $site The site ID of the site you wish to link to. The ID must
 * be included in the "mapping.txt" file. 
 * @param string $suffix An associative array of all additional GET arguments
 * you wish to add. For example, use <code>array("action" => "add")</code> to
 * add the "&action=add" parameter to the URL returned by this function.
 * @param boolean $preserve Optional boolean flag to define if the current GET
 * variables should be preserved in the new URL. Default is FALSE.
 * @return string Returns a hyperlink in the form
 * "index.php?site=<site-id>&<optional-arguments>".
 */
function get_href($site, $suffix=array(), $preserve=false) {
	$params = $suffix;
	
	if($preserve) {
		$params = array_merge($_GET, $params);
	}
	
	$params = array_replace($params, array("site" => strtolower($site)));
	return "index.php?" . str_replace('&', '&amp;', http_build_query($params));
}

/**
 * Function to print a form file.
 * @param unknown $form_file Form file to be printed
 */
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
		} 
		echo "<div class=\"formField\"> <label for =\"" . $entry [0] . "\">" . get_translation ( $entry [1] ) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry [0] . "\" size=\"" . $entry [3] . "\" maxlength=\"" . $entry [4] . "\" id=\"" . $entry [0] . "\" placeholder =\"" . get_translation ( "$entry[1]" ) ."\" value =\"" . $preset_value . "\" ></input></div>";
	}
}

/**
 * Print an address stored in the database (table "address") based on an ID.
 * 
 * @param integer $address_id The ID of the address to be printed.
 */
function print_address($address_id) {
	global $shopdb;
	global $shopuser;
	
	$query = sprintf("SELECT a.street, a.zipcode, a.city, a.country, p.name AS pname, g.name AS gname FROM address a JOIN planet p ON a.planet_id = p.planet_id JOIN galaxy g ON a.galaxy_id = g.galaxy_id WHERE a.address_id=%s LIMIT 1", $address_id);
	$address = $shopdb->get_row($query);
		
	echo "<ul>";
	echo "<li><strong>" . get_translation("FORM_NAME") . ":</strong> $shopuser->first_name $shopuser->last_name</li>";
	echo "<li><strong>" . get_translation("FORM_STREET") . ":</strong> $address->street</li>";
	echo "<li><strong>" . get_translation("FORM_AREACODE") . ":</strong> $address->zipcode</li>";
	echo "<li><strong>" . get_translation("FORM_CITY") . ":</strong> $address->city</li>";
	echo "<li><strong>" . get_translation("FORM_COUNTRY") . ":</strong> $address->country</li>";
	echo "<li><strong>" . get_translation("FORM_PLANET") . ":</strong> $address->pname</li>";
	echo "<li><strong>" . get_translation("FORM_GALAXY") . ":</strong> $address->gname</li>";
	echo "</ul>";
}

/**
 * Function to generate a complete order summary. This function generates the
 * shipping address, the order overview and all positions of an order. The
 * function expects an order ID.
 * 
 * @param integer $order_id ID of the order you want to print out.
 * @return string The complete order summary HTML
 */
function print_order($order_id) {
	global $shopdb;
	
	$output = "<h3>Shipping address:</h3>";
	
	$query = sprintf("SELECT o.order_id, o.order_date, o.shipping_date, o.shipping_address, u.first_name, u.last_name FROM `order` o JOIN user u ON o.customer_id = u.user_id WHERE o.order_id=%s", $order_id);
	$order_attributes = $shopdb->get_row($query);
	
	print_address($order_attributes->shipping_address);
	
	$output .= "<h3>Order Details</h3>";
	$output .= "<ul>";
	$output .= "<li><strong>Order ID:</strong> $order_attributes->order_id</li>";
	$output .= "<li><strong>Order Date:</strong> $order_attributes->order_date</li>";
	$output .= "<li><strong>Shipping Date:</strong> $order_attributes->shipping_date</li>";
	$output .= "<li><strong>Name on address:</strong> $order_attributes->first_name $order_attributes->last_name</li>";
	$output .= "</ul>";
	
	$output .= "<h3>Order Positions</h3>";
	$output .= "<table>";
	$output .= "<tr><th>Quantity</th><th>Product</th><th>Price</th></tr>";
	
	$query = sprintf("SELECT od.quantity, od.product_id, p.name, p.price FROM order_detail od JOIN product p ON od.product_id = p.product_id WHERE od.order_id=%s;",
				$order_attributes->order_id);
	$order_positions = $shopdb->get_results($query);
	
	$total_price = 0;
	foreach($order_positions as $position) {
			$p = new ShopProduct($position->product_id);
		
			$output .= "<tr><td>$position->quantity</td>";
			$output .= "<td><strong>$position->name</strong><br/>";
			
			// Here, get the custom attributes
			$query = sprintf("SELECT attribute_id, attribute_value FROM order_detail_attributes WHERE order_id=%s AND product_id=%s",
						$order_attributes->order_id, $position->product_id);
			$custom_attributes = $shopdb->get_results($query);
			if($custom_attributes != NULL) {
				$output .= "You chose the following custom attributes:";
				$output .= "<ul>";
				foreach($custom_attributes as $attribute) {
					$attribute_name = $p->getAttributeNameForId($attribute->attribute_id);
					$attribute_value = urldecode($attribute->attribute_value);
					$output .= "<li>$attribute_name: $attribute_value</li>";
				}
				$output .= "</ul>";
			} else {
				$output .= "This product has no custom attributes";
			}
			
			$position_price = $position->quantity * $position->price;
			$output .= "</td><td>$position_price</td></tr>";
			
			$total_price += $position_price;
	}
	$output .= "<tr><td>Total price</td><td></td><td>$total_price</td></tr>";
	$output .= "</table>";
	return $output;
}

/**
 * Function to add a galaxy to the database (used in the registration process)
 * @param string $name Name of the galaxy
 * @return Returns the ID of the just inserted galaxy (or NULL if there was
 * an error)
 */
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

/**
 * Function to add a planet to the database (used in the registration process)
 * @param string $name Name of the planet
 * @return Returns the ID of the just inserted plaet (or NULL if there was an
 * error).
 */
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

/**
 * Function to add an address to the database (used in the registration process)
 * @param string $street Street name and street number
 * @param string $zipcode Zip code of the city
 * @param string $city City name
 * @param string $country Country name
 * @param integer $planet_id ID of the planet
 * @param integer $galaxy_id ID of the galaxy
 * @return Returns the address ID of the just entered addressor NULL
 * if there was an error
 */
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

/**
 * Function to enter an order into the database (used in the checkout process).
 * Note that this only creates the order itself, you might need to enter
 * addition order details (use "db_insert_order_detail") to create a complete
 * order.
 * @param integer $customer_id ID of the customer placing the order
 * @param integer $shipping_address ID of the customer address 
 * @return Returns an order ID or NULL if there was an error
 */
function db_insert_order($customer_id, $shipping_address) {
	global $shopdb;
	
	$address_name = 'addr_' . time();
	
	$clean_cust_id = $shopdb->escape($customer_id);
	$clean_shipping_addr = $shopdb->escape($shipping_address);
	
	$query = sprintf("INSERT INTO `order` (customer_id, order_date, shipping_date, shipping_address) VALUES (%s, NOW(), NOW(), %s);",
				$clean_cust_id, $clean_shipping_addr);
	
	$result = $shopdb->query($query);
	if($result) {
		$query = sprintf("SELECT order_id FROM `order` WHERE customer_id=%s AND shipping_address=%s ORDER BY order_date DESC LIMIT 1;",
					$clean_cust_id, $clean_shipping_addr);
		$order_id = $shopdb->get_var($query);
		return $order_id;
	} else {
		$shopdb->debug();
		return null;
	}
}

/**
 * Function to add order details to an order. Typically, one would use
 * the "db_insert_order" function to create an order and add products using
 * this function here.  
 * @param integer $order_id Order ID (usually generated with *db_insert_order")
 * @param integer $product_id Product to be added to this order
 * @param integer $quantity How many products are added
 * @return boolean Returns TRUE if the entry was successful and FALSE if there
 * was an error.
 */
function db_insert_order_detail($order_id, $product_id, $quantity) {
	global $shopdb;

	if($quantity > 1) {
		// Hack: If quantity is already > 1, we might not need to INSERT (has already been done)
		$query = sprintf("SELECT COUNT(*) FROM order_detail WHERE order_id=%s AND product_id=%s",
				$order_id, $product_id);
		$result = $shopdb->get_var($query);
		if($result >= 1) {
			// Was already inserted, return TRUE
			return true;
		}
	}
	
	
	$query = sprintf("INSERT INTO order_detail (order_id, product_id, quantity) VALUES (%s, %s, %s);",
				$order_id, $product_id, $quantity);
	
	$result = $shopdb->query($query);
	if($result) {
		return true;
	} else {
		$shopdb->debug();
		return false;
	}
}

/**
 * Add custom attributes to an order detail. Typically, this is called after
 * adding order details to an order with the "db_insert_order_detail" function.
 * @param integer $order_id Order ID (usually generated with "db_insert_order")
 * @param integer $product_id Product ID
 * @param integer $attribute_id ID of the attribute to be defined in the order
 * @param string $attribute_value Value of the attribute
 * @return boolean Returns TRUE if the entry was successful and FALSE if there
 * was an error.
 */
function db_insert_order_detail_attribute($order_id, $product_id, $attribute_id, $attribute_value) {
	global $shopdb;
	
	// Hack: If there is already such a position
	$query = sprintf("SELECT COUNT(*) FROM order_detail_attributes WHERE order_id=%s AND product_id=%s AND attribute_id=%s",
			$order_id, $product_id, $attribute_id);
	$result = $shopdb->get_var($query);
	if($result >= 1) {
		// Was already inserted, return TRUE
		return true;
	}
	
	$query = sprintf("INSERT INTO order_detail_attributes (order_id, product_id, attribute_id, attribute_value) VALUES (%s, %s, %s, '%s');",
				$order_id, $product_id, $attribute_id, $attribute_value);

	$result = $shopdb->query($query);
	if($result) {
		return true;
	} else {
		$shopdb->debug();
		return false;
	}
}

?>
