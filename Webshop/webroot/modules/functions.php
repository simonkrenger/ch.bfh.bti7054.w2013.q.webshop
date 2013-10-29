<?php
function require_db() {
	global $shopdb;
	
	require_once( ABSPATH . '/modules/shopdb.php');
	
	if (! isset ( $shopdb )) {
		$shopdb = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
	}
}

/**
 * Function to check if requested $_GET['site'] is an allowed site.
 * @param unknown $site_id
 * @return string
 */
function get_safe_content_include($site_id) {
	$DEFAULT_SITE = 'home.php';
	
	if ($site_id != null) {
		$file = file ( "menu.txt" );
		foreach ( $file as $line ) {
			$valid_site = explode ( ',', $line );
			if ($valid_site [0] == $site_id) {
				return trim ( $valid_site [2] );
			}
		}
	}
	return $DEFAULT_SITE;
}


function setLanguae() {
	if ($_GET ['language'] != null)
		$language = 'en';
	else
		$lagnguage = $_GET ['language'];
}


?>