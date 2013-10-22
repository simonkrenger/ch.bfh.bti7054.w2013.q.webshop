<?php include('header.php'); ?>

<?php 


if($_GET['site'] != null) {
	$file = file ( "menu.txt" );
	foreach ( $file as $line ) {
		$valid_site = explode ( ',', $line );
		
		if($valid_site[0] == $_GET['site']) {
			$selected_site = trim($valid_site[2]);
		}
	}
	if($selected_site != null) {
		include($selected_site);
	} else {
		include('home.php');
	}
} else {
	include('home.php');
}

?>
<?php include('footer.php'); ?>