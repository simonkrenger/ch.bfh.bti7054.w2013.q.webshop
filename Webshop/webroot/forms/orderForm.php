<form class= form name="orederForm" action="sendOrder.php" method="post"
	onsubmit="submitOrderForm()" onreset="resetOrderForm()">

<?php
if (get_param ( "language", "en" ) == "de") {
	$orderFormFile = file ( "txt/de-orderForm.txt" );
} else {
	$orderFormFile = file ( "txt/en-orderForm.txt" );
}



$orderForm = array ();
foreach ( $orderFormFile as $line ) {
	array_push ( $orderForm, explode ( ',', $line ) );
}

?>


<div id="orderForm">

		<?php
		foreach ( $orderForm as $entry ) {

			
			echo "<div class=\"orderFormField\"> <label for =\"" . $entry[0] . "\">" . $entry[1] . "</label><input type=\"" . $entry [2] . "\" name=\"" . $entry[0] . "\" size=\"" . $entry[3] . "\" maxlength=\"" . $entry[4] . "\" value =\"" . $entry[0] . "\"></div>";
		}
		
		?>
	
	<div>
			Checkbox <input type="checkbox">
		</div>
		<div>
			RadioButton <input type="radio">
		</div>
		<div>
			<input type="submit" name="submitted" value="Send">
		</div>
</div>
</form>
