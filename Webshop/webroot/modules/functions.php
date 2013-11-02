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


function get_param($name, $default) {
	if (isset($_GET[$name])) {
		return urldecode($_GET[$name]);
	}
	else{
		return $default;
	}
}

function add_param($url, $name, $value, $sep="&") {
	$new_url = $url.$sep.$name."=".urlencode($value);
	return $new_url;
}




// function setLanguae($language) {
	
// 	function language() {
// 		$url = $_SERVER['PHP_SELF'];
// 		$url = add_param($url, "id", get_param("id", 0), "?");
// 	if ($_GET ['language'] != null)
// 		$language = 'en';
// 	else
// 		$lagnguage = $_GET ['language'];
// }


?>