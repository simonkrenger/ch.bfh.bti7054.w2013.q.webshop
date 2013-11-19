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

function require_login() {
	session_start();
	
	if(isset($_GET["logout"]) && isset($_SESSION["islogged_in"])) {
		session_destroy();
		header('Location: /index.php');
		exit();
	}
}

function require_secure() {
	session_start();
	
	if (!isset($_SESSION["islogged_in"])) {
		header('Location: /index.php');
		exit();
	}
}

function is_logged_in() {
	if (isset($_SESSION["logged_in"])) {
		return true;
	}
	return false;
}

function require_lang() {
	global $language;
	
	require_once('language.php');
	if (! isset ( $language )) {
		$language = get_language(); // Fränzi: Replace me!
		// Further reading: Read browser agent language (optional)
	}
}

function breadcrumb($setCrumb, $addCrumb){
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

function get_href($site, $suffix=array()) {
	$params = array_merge($_GET, $suffix);
	
	$params = array_replace($params, array("site" => $site));
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
