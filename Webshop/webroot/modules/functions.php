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
					$_SESSION ["cart"]->addItem ( $_GET ["product_id"],1);
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

function breadcrumb($setCrumb=NULL, $addCrumb=NULL){
	/*if no crumb is set, set to empty string*/
	if ($addCrumb == NULL) {
		$addCrumb = "";
	}
	/*return breadcrumb according to actual breadCrumb*/
	if ($setCrumb == NULL)
		return $addCrumb;
	else if (strpos($setCrumb, $addCrumb) !== false){
		return strstr($setCrumb, $addCrumb, true).">" . $addCrumb;
	}
	else {
		return $setCrumb.">".$addCrumb;
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


?>
