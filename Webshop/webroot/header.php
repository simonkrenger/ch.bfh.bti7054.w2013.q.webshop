<?php include('config.php'); // First order of business, load config ?>
<?php include('modules/functions.php'); ?>

<?php require_db(); ?>
<?php require_lang();?>

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
					<a href="<?php echo get_href("home"); ?>"><img src="images/logo-white.png" alt="Logo" /></a>
				</div>

			</div>

			<div id="language">
			
			<?php
			$url = $_SERVER['PHP_SELF'];
			
echo "<a href=\"". $url . "?language=de\">DE</a> | ";
echo "<a href=\"". $url . "?language=en\">EN</a>";
			?>
		
			
			</div>
			<!-- 			<div id="search"></div> -->
				<?php include('menu.php'); ?>

		</div>

