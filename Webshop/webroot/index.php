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
