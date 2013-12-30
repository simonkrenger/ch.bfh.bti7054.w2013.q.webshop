


<form class="form" name="orderForm" id="orderForm"
	action="<?php
	$suffix = array ();
	echo get_href ( "sendOrder", $suffix, true );
	?>"
	method="post" onsubmit="submitOrderForm()" onreset="resetOrderForm()">
	

<?php
global $language;

$orderFormFile = file ( ABSPATH . "modules/forms/orderForm.txt" );

$orderForm = array ();
foreach ( $orderFormFile as $line ) {
	array_push ( $orderForm, explode ( ',', $line ) );
}

?>


<div class="form">

		<?php
		foreach ( $orderForm as $entry ) {
			echo "<div class=\"orderFormField\"> <label for =\"" . $entry [0] . "\">" . get_translation ( $entry [1] ) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry [0] . "\" size=\"" . $entry [3] . "\" maxlength=\"" . $entry [4] . "\" id=\"" . $entry [0] . "\" placeholder =\"" . get_translation ( "$entry[1]" ) ."\" value =\"" . get_translation ( "$entry[1]" ) . "\" ></input></div>";
		}
		
		?>
	
		<div>
			<input type="button" name="submitted" value="Order now!"
				onclick="verifyOrderForm()" />
		</div>
	</div>
</form>

