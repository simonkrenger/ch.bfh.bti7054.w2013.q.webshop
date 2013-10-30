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
		$file = file ( "mapping.txt" );
		foreach ( $file as $line ) {
			$valid_site = explode ( ',', $line );
			if ($valid_site [0] == $site_id) {
				return trim ( $valid_site [1] );
			}
		}
	}
	return $DEFAULT_SITE;
}

function print_menu() {

	global $shopdb;
	
	// Home link
	echo "<div class=\"menuentry\" id=\"home\"><a href=\"/\">" . get_translation ( "MENU_HOME" ) . "</a></div>";
	
	$categories = $shopdb->get_results ( "SELECT category_id,translation_string FROM product_category ORDER BY category_id" );
	foreach ( $categories as $category ) {
		echo "<div class=\"menuentry\" id=\"" . $category->translation_string . "\"><a href=\"index.php?site=products&category=" . $category->category_id . "\">" . get_translation ( $category->translation_string ) . "</a></div>";
	}
	
	// Shopping cart
	echo "<div class=\"menuentry\" id=\"shoppingcart\"><a href=\"/\">" . get_translation ( "MENU_SHOPPINGCART") . "</a></div>";

	// Login
	echo "<div class=\"menuentry\" id=\"login\"><a href=\"/\">" . get_translation ( "MENU_LOGIN" ) . "</a></div>";
}

?>
