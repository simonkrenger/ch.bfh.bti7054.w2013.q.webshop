<?php

if ($language == de){
$file = file ( "de-menu.txt" ); 
}
else {
	$file = file ( "en-menu.txt" );
}

$menu = array();
foreach ( $file as $line ) {
	array_push ( $menu, explode ( ',', $line ) );

}

?>

<div id="menu">
	<!-- <div class="menuentry" id="home"><a href="/index.html">Home</a></div> -->
				<?php
				
				$url = $_SERVER['PHP_SELF'];
				foreach ($menu as $menuentry){
					echo "<div class=\"menuentry\" id=\"".$menuentry[0]."\"> <a href=\"". $url . "?site=" . $menuentry[0] . "\"> " . $menuentry[1] . "</a></div>"; 
				}

					
				?>
			</div>