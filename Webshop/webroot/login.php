<?php 
/**
 * Login page. Shows a login form or basic user information
 */

?>
<div id="content">
	<div id="maincontent">
		<div id="contentarea">
			<h2><?php echo get_translation("MENU_LOGIN"); ?></h2>
			<?php if(!is_logged_in()) {
				if(isset($_GET["login_failed"])) {
					echo '<div id="warn">' . get_translation("LOGIN_FAILED") . '</div>';
				}
				include(ABSPATH . '/modules/login/loginform.php');
			} else { ?>
				<p><?php echo sprintf(get_translation("LOGIN_SUCCESSFUL"), $shopuser->first_name); ?></p>
				<p><a href="<?php echo get_href("login", array("logout" => "true")); ?>">Logout</a></p>
			<?php } ?>
		</div>
	<?php include('sidebar.php'); ?>
	</div>
</div>