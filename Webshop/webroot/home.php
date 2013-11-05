
<div id="content">
	<div id="marketing">
		<div class="marketing-text">
			Planets on sale!
			<div class="marketing-subtext">
				... because noone else wanted them. <a href="default.php">Find out
					more</a>
			</div>
		</div>
	</div>
				<div id="maincontent">	
			
			<?php
			$language = get_param ( "language", "en" );
			
			if ($language == de) {
				$file = file ( "txt/de-category.txt" );
			} else {
				$file = file ( "txt/en-category.txt" );
			}
			
			$category = array ();
			foreach ( $file as $line ) {
				array_push ( $category, explode ( ',', $line ) );
			}
			
			?>

<span id="category">
				<?php
				
				foreach ( $category as $cat) {
					echo "<div class=\"categorytile\">". $cat[0] . "</div>";
				}
				
				?>
		</span>
	</div>