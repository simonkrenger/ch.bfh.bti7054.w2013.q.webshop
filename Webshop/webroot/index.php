
<?php function setLanguae() {
	if ($_GET ['language'] != null)
		$language = 'en';
	else
		$lagnguage = $_GET ['language'];
}
setLanguae();


 ?>
<?php include('header.php'); ?>


<?php include(get_safe_content_include($_GET['site'])); ?>


<?php include('footer.php'); ?>
