<?php
if (isset ( $_POST ["username"] ) && isset ( $_POST ["password"] )) {
	global $shopdb;
	
	$cleaned_username = $shopdb->escape($_POST ["username"]);
	$cleaned_password = $shopdb->escape($_POST ["password"]);
	
	$query = sprintf("SELECT user_id, username, email, first_name, last_name, role_id FROM user WHERE username='%s' AND password=md5('%s') LIMIT 1", $cleaned_username, $cleaned_password);
	$login_user = $shopdb->get_row($query);
	
	if($login_user != NULL) {
		$_SESSION["logged_in"] = true;		
		$login_message = get_translation("LOGIN_SUCCESSFUL");
	} else {
		$login_message = get_translation("LOGIN_FAILED");
	}
}


?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			<h2><?php echo get_translation("MENU_LOGIN"); ?></h2>
			<p><?php echo $login_message; ?></p>
			<?php include(ABSPATH . '/modules/login/loginform.php'); ?>
		</div>
	
			<?php include('sidebar.php'); ?>
			</div>
</div>