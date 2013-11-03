
		<div id="content">
			<div id="marketing">
				<div class="marketing-text">
					<?php echo get_translation("MARKETING_CLAIM_BIG"); ?>
					<div class="marketing-subtext">
						<?php echo get_translation("MARKETING_CLAIM_SUBTEXT"); ?> <a href="<?php echo get_href("products","&category=2") ?>"><?php echo get_translation("MARKETING_FIND_OUT_MORE"); ?></a>
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
