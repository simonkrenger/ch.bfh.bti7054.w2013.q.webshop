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
					<a href="/"><img src="images/logo-white.png" alt="Logo" />
						PlanetShop </a>
				</div>
			</div>

			<!-- 			<div id="search"></div> -->
			<?php
			$menu = array (
					"home" => array ("name" => "Home", "href" => "/index.php"),
					"predefined" => array ("name" => "Predefined", "href" => "/default.php"),
					"onsale" => array ("name" => "On Sale", "href" => "/default.php"),
					"custom" => array ("name" => "Custom", "href" => "/default.php"),
					"satellites" => array ("name" => "Satellites", "href" => "/default.php"),
					"accessories" => array ("name" => "Accessories", "href" => "/default.php"),
					"shoppingcart" => array ("name" => "Shopping Cart", "href" => "/default.php"),
					"login" => array ("name" => "Login", "href" => "/default.php")
			);

			
			?>
			<div id="menu">
<!-- 				<div class="menuentry" id="home"><a href="/index.html">Home</a></div> -->
				<?php 	
						
			foreach ($menu as $id => $link) {
				echo "<div class=\"menuentry\" id=\"$id\"> <a href=\"$link[href]\">$link[name]</a> </div>";

			}?>
			</div>


		</div>