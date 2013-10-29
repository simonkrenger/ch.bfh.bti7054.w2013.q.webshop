<?php

class shopdb {
	
	private $dbusername;
	private $dbpassword;
	private $dbname;
	private $dbhost = 'localhost';
	
	private $ready = false;
	
	function __construct( $dbuser, $dbpassword, $dbname) {
		$this->dbusername = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		
		$this->db_connect();
	}
	
	function db_connect() {
		
		$this->ready = true;
	}
	
	function get_row(){}
	
}

?>