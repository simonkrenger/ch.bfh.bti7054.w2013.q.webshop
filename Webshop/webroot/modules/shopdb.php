<?php
include_once('db/ez_sql_mysqli.php');
include_once('db/ez_sql_core.php');

class shopdb {
	
	private $dbhost = 'localhost';
	
	private $ready = false;
	
	private $db;
	
	function __construct( $dbuser, $dbpassword, $dbname) {
		if (!isset($db)) {
			$db = new ezSQL_mysqli($dbuser, $dbpassword, $dbname, $dbhost);
		}
		return $db;
	}
	
	
	
	function get_row(){}
	
}

?>