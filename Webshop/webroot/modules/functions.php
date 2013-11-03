<?php

function require_db() {
	global $shopdb;
	
	require_once('db/ez_sql_core.php');
	require_once('db/ez_sql_mysqli.php');
	
	if (! isset ( $shopdb )) {
		// The DB_* values were set in 'config.php'
		$shopdb = new ezSQL_mysqli ( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
	}
}

function require_lang() {
	global $language;
	
	require_once('language.php');
	if (! isset ( $language )) {
		$language = get_language();
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
		$file = file ( "txt/mapping.txt" );
		foreach ( $file as $line ) {
			$valid_site = explode ( ',', $line );
			if ($valid_site [0] == $site_id) {
				return trim ( $valid_site [1] );
			}
		}
	}
	return $DEFAULT_SITE;
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
	
function get_href($site, $suffix=null) {
	
	if(isset($_GET['language'])) {
		return "index.php?site=" . $site . "&language=" . $_GET['language'] . $suffix;
	}
	
	return "index.php?site=" . $site . $suffix;
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




function print_menu() {

	global $shopdb;
	
	// Home link
	echo "<div class=\"menuentry\" id=\"home\"><a href=\"". get_href("") ."\">" . get_translation ( "MENU_HOME" ) . "</a></div>";
	
	$categories = $shopdb->get_results ( "SELECT category_id,translation_string FROM product_category ORDER BY category_id" );
	foreach ( $categories as $category ) {
		echo "<div class=\"menuentry\" id=\"" . $category->translation_string . "\"><a href=\"". get_href("products", "&category=" . $category->category_id) . "\">" . get_translation ( $category->translation_string ) . "</a></div>";
	}
	
	// Shopping cart
	echo "<div class=\"menuentry\" id=\"shoppingcart\"><a href=\"". get_href("shoppingcart") . "\">" . get_translation ( "MENU_SHOPPINGCART") . "</a></div>";

	// Login
	echo "<div class=\"menuentry\" id=\"login\"><a href=\"". get_href("login") . "\">" . get_translation ( "MENU_LOGIN" ) . "</a></div>";
}

?>

