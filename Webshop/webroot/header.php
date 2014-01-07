<!DOCTYPE html>
<html lang="<?php global $language; echo $language; ?>">
<head>
<meta charset="UTF-8">
<title>PlanetShop</title>
<link rel="stylesheet" type="text/css" href="style/planetshop.css" />
<script type="text/javascript" src="/js/planetshop.js"></script>
</head>
<body>
	<noscript>This site needs JavaScript!</noscript>
	<div id="container">
		<!-- Header: on every Page -->
		<div id="navigation">
			<div id="logo">
				<div id="companyname">
					<a href="<?php echo get_href("home", array()); ?>"><img src="images/logo-white.png" alt="Logo" /></a>
				</div>
			</div>
			<div id="menu">

			<div class="language">
			
			<?php
			
			if(isset($_GET["site"])) {
				$cur_site = $_GET["site"];
			} else {
				$cur_site = "home";
			}
			
			echo "<a href=\"". get_href($cur_site, array("switch_lang" => "de"), true) . "\" >DE</a> |";
			echo "<a href=\"". get_href($cur_site, array("switch_lang" => "en"), true) . "\" >EN</a>";
			
			?>
			
			</div>
			
				<?php include('menu.php'); ?>

		</div>
		
		

