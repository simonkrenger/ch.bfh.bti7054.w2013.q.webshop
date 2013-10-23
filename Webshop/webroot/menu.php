<?php
$file = file ( "menu.txt" ); 

$menu = array();
foreach ( $file as $line ) {
	array_push ( $menu, explode ( ',', $line ) );

}
?>

<div id="menu">
	<!-- <div class="menuentry" id="home"><a href="/index.html">Home</a></div> -->
				<?php
				
				
				foreach ($menu as $menuentry){
					echo "<div class=\"menuentry\" id=\"".$menuentry[0]."\"> <a href=\"index.php?site=" . $menuentry[0] . "\"> " . $menuentry[1] . "</a></div>"; 
				}

					
				?>
			</div>