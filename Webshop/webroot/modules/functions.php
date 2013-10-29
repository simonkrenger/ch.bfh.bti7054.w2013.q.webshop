<?php
function require_db() {
	global $shopdb;
	
	if (! isset ( $shopdb )) {
		$shopdb = new shopdb ( $username, $password, $dbname );
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


function setLanguae() {
	if ($_GET ['language'] != null)
		$language = 'en';
	else
		$lagnguage = $_GET ['language'];
}


?>