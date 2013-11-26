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

<?php require_db(); ?>
<?php require_login(); ?>
<?php require_lang();?>
<?php require_user(); ?>
<?php require_shoppingcart(); ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PlanetShop</title>
<link rel="stylesheet" type="text/css" href="style/planetshop.css" />
<script type="text/javascript" src="/js/planetshop.js"></script>
<noscript>This site needs JavaScript!</noscript>
</head>
<body>
	<div id="container">

		<!-- Header: on every Page -->
		<div id="navigation">

			<div id="logo">
				<div id="companyname">
					<a href="<?php echo get_href("home", array()); ?>"><img src="images/logo-white.png" alt="Logo" /></a>
				</div>

			</div>

			<div id="language">
			
			<?php
			
			if(isset($_GET["site"])) {
				$cur_site = $_GET["site"];
			} else {
				$cur_site = "home";
			}
			
			echo "<a href=\"". get_href($cur_site, array("language" => "de")) . "\">DE</a> | ";
			echo "<a href=\"". get_href($cur_site, array("language" => "en")) . "\">EN</a>";
			?>
			
			</div>
			<!-- 			<div id="search"></div> -->
				<?php include('menu.php'); ?>

		</div>
<?php include('modules/breadcrumb.php') ?>
