
<?php

$language = get_param("language", "en");

if ($language == de){
$file = file("txt/de-menu.txt"); 
 }
 else {
 	$file = file ("txt/en-menu.txt");
 }

$menu = array();
foreach ( $file as $line ) {
	array_push ( $menu, explode ( ',', $line ) );

}

?>
<div id="menu">
				<?php print_menu(); ?>
			</div>

