<div id="content">
        <div id="maincontent">
                <div id="contentarea">

                <h1><?php echo get_translation("MENU_SHOPPINGCART")?></h1>

                <?php $_SESSION["cart"]->displayFull(); ?>

                <div class="separator"></div>
                <div class="box" id="planetButtons" >  
                <?php if( ! $_SESSION["cart"]->is_empty() ) { ?>
                		<a href="<?php echo get_href("checkout") ?>">
							<?php echo get_translation("SHOPPINGCART_CHECKOUT"); ?>
						</a>
                		<br/>
                		</div>
                		<div class="box" id="planetButtons" >  
                        <a href="<?php
                                        $suffix = array( "action" => "clear");
                                        echo get_href("shoppingcart", $suffix); ?>">
                                        <?php echo get_translation("SHOPPINGCART_CLEAR_CART")?>
                        </a>
                <?php } ?>
                </div>
                </div>
		 <?php include('sidebar.php'); ?>
			</div>
		</div>