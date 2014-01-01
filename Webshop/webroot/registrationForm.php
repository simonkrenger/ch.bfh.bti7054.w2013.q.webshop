<form class="form" name="registrationForm" id="registrationForm" action="<?php echo get_href("sendReg"); ?>" method="post"
	onsubmit="submitForm()" onreset="resetForm()">
	

<?php
global $language;

$regFormFile = file (ABSPATH."modules/forms/regForm.txt");


$regForm = array ();
foreach ( $regFormFile as $line ) {
	array_push ($regForm, explode ( ',', $line ));
}

?>


<div class="form">

		<?php
		foreach ( $regForm as $entry ) {
			echo "<div class=\"regFormField\"> <label for =\"" . $entry[0] . "\">" . get_translation($entry[1]) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry[0] . "\" size=\"" . $entry[3] . "\" maxlength=\"" . $entry[4] . "\" id=\"" . $entry[0] . "\" placeholder =\"" . get_translation("$entry[1]").  "\" ></input></div>";
		}
		
		echo "repeat Password: " . 
		"<div class=\"regFormField\"> <label for =\"" . $entry[0] . "\">" . get_translation($entry[1]) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry[0] . "\" size=\"" . $entry[3] . "\" maxlength=\"" . $entry[4] . "\" id=\"" . $entry[0] . "\" placeholder =\"" . get_translation("$entry[1]").  "\" ></input></div>";
		?>
	
		<div>
			<input type="button" name="submitted" value="<?php get_translation("FORM_REG_REG")?>" onclick="verifyForm()"/>
		</div>
</div>
</form>



