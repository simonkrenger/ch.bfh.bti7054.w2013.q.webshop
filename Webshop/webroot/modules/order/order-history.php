<?php
/**
 * Returns AJAX result for order history
 * 
 * Looks familiar, doesn't it? :)
 */

// Ok, this is quite ugly. Since this is a standalone site (no index.php)
// we need to manually include all our libraries and configurations.

if(file_exists('../../config.php')) {
	include('../../config.php'); // First order of business, load config
} else {
	// No config.php found, break
	echo "ERROR: No config.php found, exiting";
	exit(1);
}

// This includes the most basic functions
include('../functions.php');

function __autoload($classname) {
	$filename = $classname .".class.php";
	include_once(ABSPATH . "modules/classes/" . $filename);
}

require_session();
require_db();
require_login();
require_user();

// End of ugly code

if(is_logged_in()) {
	
	global $shopuser;
	global $shopdb;
	
	$limit = 10;
	if(isset($_GET["limit"])) {
		$limit = $_GET["limit"];
	}
	
	$offset = 0;
	if(isset($_GET["offset"])) {
		$offset = $_GET["offset"];
	}
	
	$query = sprintf("SELECT o.order_id, o.order_date, sum(od.quantity) quant, sum(od.quantity*p.price) total FROM `order` o JOIN order_detail od ON o.order_id = od.order_id JOIN product p ON od.product_id = p.product_id WHERE o.customer_id=%s GROUP BY order_id, order_date ORDER BY order_date DESC LIMIT %s,%s;", $shopuser->user_id, $shopdb->escape($offset), $shopdb->escape($limit));
	$result = $shopdb->get_results($query);
	if($result) {
		echo "<table>";
		echo "<tr><th>Order ID</th><th>Date</th><th>Articles</th><th>Total Price</th></tr>";
		foreach($result as $order) {
			echo "<tr>";
			echo '<td><a href="' . get_href("orderhistory", array("order_detail" => $order->order_id)) . '">' . $order->order_id . '</a></td>';
			echo "<td>$order->order_date</td>";
			echo "<td>$order->quant</td>";
			echo "<td>$order->total</td>";
			echo "</tr>";
		}
		echo "</table>";
	} else {
		$shopdb->debug();
	}
} else {
	echo "Error: User not logged in";
}