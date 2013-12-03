<form class="form" name="orderForm" id="orderForm" action="<?php echo get_href("sendOrder"); ?>" method="post"
	onsubmit="submitOrderForm()" onreset="resetOrderForm()">
	

<?php
if (get_param ( "language", "en" ) == "de") {
	$orderFormFile = file (ABSPATH .  "modules/order/de-orderForm.txt" );
} else {
	$orderFormFile = file (ABSPATH . "modules/order/en-orderForm.txt" );
}



$orderForm = array ();
foreach ( $orderFormFile as $line ) {
	array_push ( $orderForm, explode ( ',', $line ) );
}

?>


<div class="form">

		<?php
		foreach ( $orderForm as $entry ) {

			
			echo "<div class=\"orderFormField\"> <label for =\"" . $entry[0] . "\">" . $entry[1] . "</label><input type=\"" . $entry [2] . "\" name=\"" . $entry[0] . "\" size=\"" . $entry[3] . "\" maxlength=\"" . $entry[4] . "\" id=\"" . $entry[0] . "\" placeholder =\"" . $entry[0] . "\"></div>";
		}
		
		?>
	
	<div>
			Checkbox <input type="checkbox">
		</div>
		<div>
			RadioButton <input type="radio">
		</div>
		<div>
			<input type="button" name="submitted" value="Order now!" onclick="verifyOrderForm()"/>
		</div>
</div>
</form>

