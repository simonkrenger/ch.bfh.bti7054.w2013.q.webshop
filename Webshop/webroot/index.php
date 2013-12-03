<?php 
if(file_exists('config.php')) {
	include('config.php'); // First order of business, load config
} else {
	// No config.php found, break
	echo "ERROR: No config.php found, exiting";
	exit(1);
}
include('modules/functions.php');
?>
<?php include('modules/classes/ShoppingCart.php'); ?>

<?php session_start(); //TODO Simon: move me ?>
<?php require_db(); ?>
<?php require_login(); ?>
<?php require_lang();?>

<?php include('header.php'); ?>
<!-- END header -->
<!-- START main content -->
<?php 
if(isset($_GET['site'])) {
	include(get_safe_content_include($_GET['site']));
} else {
	include(get_safe_content_include("home"));
} ?>
<!-- END main content -->

<!-- START footer -->
<?php include('footer.php'); ?>
<!-- END footer -->