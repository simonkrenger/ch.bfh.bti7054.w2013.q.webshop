<div id="content">
	<div id="maincontent">
		<div id="contentarea-fullwidth">

			<h2>Administration</h2>
<?php
if (is_logged_in () && is_admin_user ()) {
	include_once (ABSPATH . "modules/functions_admin.php");
	
	switch ($_GET ["action"]) {
		case "doedit" :
			admin_update ( $_GET ["type"], $_GET ["id"] );
			admin_list ( $_GET ["type"] );
			break;
		case "doadd" :
			admin_add ( $_GET ["type"] );
			admin_list ( $_GET ["type"] );
			break;
		case "dodelete" :
			admin_delete ( $_GET ["type"] );
			admin_list ( $_GET ["type"] );
			break;
		case "list" :
		default :
			admin_list ( $_GET ["type"] );
			break;
		case "edit" :
			admin_show_form ( $_GET ["type"], $_GET ["id"] );
			break;
		case "add" :
			admin_show_form ( $_GET ["type"] );
			break;
		case "delete" :
			admin_show_delete_form ( $_GET ["type"], $_GET ["id"] );
			break;
	}
} else {
	echo get_translation("ACCESS_DENIED");
}

?>
		</div>
	</div>
</div>