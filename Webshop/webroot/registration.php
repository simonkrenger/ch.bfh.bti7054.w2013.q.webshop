
<div id="content">
	<div id="maincontent">
		<div id="contentarea">

			<form class="form" name="registrationForm" id="registrationForm"
				action="<?php echo get_href("sendReg"); ?>" method="post"
				onsubmit="submitForm()" onreset="resetForm()">

				<div class="form">

		<?php print_form_fields ( "modules/forms/regForm.txt" );
		
		echo "repeat Password: " . "<div class=\"formField\"> <label for =\"" . $entry [0] . "\">" . get_translation ( $entry [1] ) . "</label>
			<input type=\"" . $entry [2] . "\" name=\"" . $entry [0] . "\" size=\"" . $entry [3] . "\" maxlength=\"" . $entry [4] . "\" id=\"" . $entry [0] . "\" placeholder =\"" . get_translation ( "$entry[1]" ) . "\" ></input></div>";
		?>
	
		<div class="button">
						<input type="button" name="submitted"
							value="<?php echo get_translation("FORM_REG");?>"
							onclick="verifyForm()" />
					</div>
				</div>
			</form>
		</div>
			
			<?php include('sidebar.php'); ?>
			</div>
</div>