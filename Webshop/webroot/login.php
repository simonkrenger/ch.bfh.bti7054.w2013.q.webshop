<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			<h2><?php echo get_translation("MENU_LOGIN"); ?></h2>
			<?php if(!is_logged_in()) {
				include(ABSPATH . '/modules/login/loginform.php');
			} else { ?>
				<p><?php echo "Welcome " . $_SESSION["first_name"] . " " . $_SESSION["last_name"] . "!"; ?></p>
				<p><a href="<?php echo get_href("login", array("logout" => "true")); ?>">Logout</a></p>
			<?php } ?>
		</div>
	<?php include('sidebar.php'); ?>
	</div>
</div>