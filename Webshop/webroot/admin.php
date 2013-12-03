<div id="content">
	<div id="maincontent">
		<div id="contentarea">
		
		<h2>Administration</h2>
<?php

if(is_logged_in() && is_admin_user()) {
	include_once(ABSPATH . "modules/functions_admin.php");
	
	switch($_GET["action"])  {
		case "list":
		default:
			admin_list($_GET["type"]);
			break;
	}
} else {
	echo "Access denied: Not logged in or no admin user.";	
}

?>
		
		</div>
	<?php include('sidebar.php'); ?>
	</div>
</div>