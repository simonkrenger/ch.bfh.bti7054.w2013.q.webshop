<?php include('modules/functions.php'); ?>
<?php include('modules/shopdb.php'); ?>
<?php //setLanguae();?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PlanetShop</title>
<link rel="stylesheet" type="text/css" href="style/planetshop.css" />
</head>
<body>
	<div id="container">

		<!-- Header: on every Page -->
		<div id="navigation">

			<div id="logo">
				<div id="companyname">
					<a href="/"><img src="images/logo-white.png" alt="Logo" /></a>
				</div>

			</div>

			<div id="language">
			
			<?php
						
			function language() {
				$url = $_SERVER['PHP_SELF'];
				$url = add_param($url, "site", get_param("site", "home"), "?");
				echo "<a href=\"".add_param($url,"language","de")."\">DE</a> | ";
				echo "<a href=\"".add_param($url,"language","en")."\">EN</a> ";
			}
			
			language();
			
			?>
		
			
			</div>
			<!-- 			<div id="search"></div> -->
				<?php include('menu.php'); ?>
				<?php include('forms/orderForm.php'); ?>
		</div>

