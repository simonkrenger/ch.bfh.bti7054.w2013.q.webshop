<?php
if (isset ( $_POST ["username"] ) && isset ( $_POST ["password"] )) {
	// Login process here
}
?>

<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			<h2><?php echo get_translation("MENU_LOGIN"); ?></h2>
			<?php include(ABSPATH . '/modules/login/loginform.php'); ?>
		</div>
	
			<?php include('sidebar.php'); ?>
			</div>
</div>